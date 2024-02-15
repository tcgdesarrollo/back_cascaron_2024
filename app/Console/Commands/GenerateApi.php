<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dynamically api from endpoints';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('clear:logs');
        $this->mergeJson();
    }

    public function mergeJson(): void
    {
        $start = json_decode(file_get_contents(resource_path('api/start.json')), true);
        $end = json_decode(file_get_contents(storage_path('app/postman/' . Str::lower(env('APP_NAME')) . '_collection.json')), true);
        $headers = [
            "_postman_id" => $start["info"]["_postman_id"],
            "name" => Carbon::now()->format("Y_m_d_A") . "_ballywulff_collection.json",
            "schema" => $start["info"]["schema"],
            "_exporter_id" => $start["info"]["_exporter_id"],
            "_collection_link" => $start["info"]["_collection_link"]
        ];
        $start["info"] = $headers;
        $end["info"] = $headers;
        $start['item'] = $this->cleanItems($start['item']);
        $end['item'] = $this->cleanItems($end['item']);
        $file_to = fopen('api.json', 'w');
        $result = array_replace_recursive($end, $start);
        if (isset($start['variable']))
            $result['variable'] = $this->setVariables($start['variable']);
        $result['event'] = $this->setGlobalEvents();
        fwrite($file_to, json_encode($result));
        fclose($file_to);
    }

    private function setGlobalEvents()
    {
        $words = json_encode($this->wordsGenerator(rand(3, 10)));
        $prerequest = [
            "listen" => "prerequest",
            "script" => [
                "type" => "text/javascript",
                "exec" => [
                    "pm.collectionVariables.set(\"INT5\", Math.floor(Math.random()*5))",
                    "pm.collectionVariables.set(\"INT10\", Math.floor(Math.random()*10))",
                    "pm.collectionVariables.set(\"INT50\", Math.floor(Math.random()*50))",
                    "pm.collectionVariables.set(\"INT100\", Math.floor(Math.random()*100))",
                    "pm.collectionVariables.set(\"BOOLEAN\", Math.floor(Math.random()*2))",
                    "function randomDate(start, end) {",
                    "        return new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));",
                    "}",
                    "var date = randomDate(new Date(2000, 0, 1), new Date());",
                    "var year_last_integer = Math.floor(Math.random() * 10);",
                    "const month = date.getMonth()+1;",
                    "const real_month = month < 10? `0$" . "{month}`: month;",
                    "var formattedDate =  '199' + year_last_integer + '/' +real_month + '/' + date.getDate();",
                    "pm.collectionVariables.set(\"date\", formattedDate)",
                    "",
                    "",
                    ""
                ]]
        ];
        $postrequest =
            [
                "listen" => "test",
                "script" => [
                    "type" => "text/javascript",
                    "exec" => [
                        ""
                    ]
                ]
            ];

        return [$prerequest, $postrequest];

    }

    private function wordsGenerator($size, $is_json = false)
    {
        $results = [];
        foreach (range(1, $size) as $item) {
            $results[] = Str::random(5);
        }
        return $results;
    }

    private function cleanItems($items): array
    {
        $results = [];
        foreach ($items as $namespace) {
            $namespace_items = [
                "name" => $namespace['name'],
                "item" => []
            ];
            foreach ($namespace['item'] as $key => $item) {
                $request = null;
                if (array_key_exists('item', $item)) {
                    $subelement = $item['item'][0];
                    if (array_key_exists('item', $subelement)) {
                        $request = $subelement["item"][0];
                    } else {
                        $request = $subelement;
                    }
                } else {
                    $request = $item;
                }
                if (isset($request)) {
                    $request = $this->setEvent($request);
                    $request['request']['auth'] = $this->setToken($request['request']);
                    $request['request']['url'] = $this->setUrl($request['request']['url']);
                    $request['request']['body'] = $this->getBody($request['request'], $request['name']);
                    $namespace_items["item"][] = $request;
                    $copy = $this->createCopy($request, key: $key);
                    $copy = $this->setEvent($copy, false);
                    $namespace_items["item"][] = $copy;
                }
            }
            $names = [];
            foreach ($namespace_items['item'] as $item) {
                $names[] = $item['name'];
            }
            array_multisort($names, SORT_ASC, $namespace_items['item']);
            $results[] = $namespace_items;
        }
        return $results;
    }

    private function createCopy($original, $key = null): array
    {
        $copy = $original;
        $copy['request']['auth'] = $this->setToken($copy['request'], false, key: $key);
        $copy['name'] = "SERVER_" . $copy['name'];
        $copy['request']['body'] = $this->getBody($copy['request'], $copy['name']);
        $copy['request']['url'] = $this->setUrl($copy['request']['url'], false);
        return $copy;

    }

    private function setUrl($request, $is_local = true)
    {
        if ($is_local) {
            $request['raw'] = '{{LOCAL_URL}}/api/auth/login';
            $request['host'] = '{{LOCAL_URL}}';
        } else {
            $request['raw'] = '{{SERVER_URL}}/api/auth/login';
            $request['host'] = '{{SERVER_URL}}';
        }
        return $request;
    }

    private function setToken($auth, $is_local = true, $key = null): array
    {
        $url = $auth['url']['path'];
        Log::debug("url", [$url, $is_local, $key]);
        if ($url == ["api", "auth", "login"]) {
            return [
                "type" => "noauth"
            ];
        }
        if ($is_local) {
            return [
                'type' => 'bearer',
                'bearer' =>
                    [
                        [
                            'key' => 'token',
                            'value' => '{{TOKEN}}',
                            'type' => 'string',
                        ],
                    ],
            ];
        }
        return [
            'type' => 'bearer',
            'bearer' =>
                [
                    [
                        'key' => 'token',
                        'value' => '{{TOKEN_SERVER}}',
                        'type' => 'string',
                    ],
                ],
        ];;
    }

    private function setEvent($request, $is_local = true): array
    {
        if (!isset($request['event'])) {
            $request['event'] = [];
        }
        if (str_contains($request['name'], 'api/auth/login')) {
            if ($is_local)
                $request['event'][0]['script']['exec'][0] = 'pm.collectionVariables.set(\'TOKEN\',pm.response.json().data)';
            else
                $request['event'][0]['script']['exec'][0] = 'pm.collectionVariables.set(\'TOKEN_SERVER\',pm.response.json().data)';
        }

        return $request;
    }

    private function setVariables($variables)
    {
        $server_url = [
            'key' => 'SERVER_URL',
            'value' => 'https://ballywulff.thecloudgroup.tech',
        ];
        $local_url = [
            'key' => 'LOCAL_URL',
            'value' => 'http://localhost:8022',
        ];
        $variables[] = $server_url;
        $variables[] = $local_url;
        $final_keys = [];
        $results = [];
        foreach ($variables as $variable) {
            if (!in_array($variable['key'], $final_keys) && $variable['key'] != 'base_url') {
                $results[] = $variable;
                $final_keys[] = $variable['key'];
            }
        }
        return $results;

    }

    private function getBody($request, $request_name)
    {
        $method = $request['method'];
        if (array_key_exists('body', $request)) {
            $body = $request['body'];
        } else {
            $body = [
                'mode' => 'raw',
                'raw' => json_encode('{}'),
                'options' =>
                    [
                        'raw' =>
                            [
                                'language' => 'json',
                            ],
                    ],
            ];
        }
        if (str_contains($request_name, 'api/auth/register')) {
            $body['raw'] = json_encode([
                'name' => '{{$randomFirstName}}',
                'lastname' => '{{$randomLastName}}',
                'email' => '{{$randomExampleEmail}}',
                'address' => '{{$randomStreetAddress}}',
                'member_number' => '{{$randomInt}}',
                'city_id' => '{{$randomInt}}',
                'state_id' => '{{INT10}}',
                'country_id' => '{{INT10}}',
                'language' => 'en',
            ]);
        }

        if (str_contains($request_name, 'api/auth/login')) {
            $body['raw'] = json_encode([
                'email' => 'superadmin@test.com',
                'password' => 'Pruebas123*',
            ]);
        }

        $columns_excluded = [
            'id',
            'created_at',
            'updated_at',
            'email_verified_at',
            'deleted_at',
            'created_by_id',
            'activated_by_id',
            'api_token',
        ];
        $excluded = [];
        if (!str_contains($request_name, 'auth') && !in_array($request_name, $excluded) && $request['method'] == 'POST') {
            $model_name = explode('/', $request_name);
            if (count($model_name) == 2) {
                $plural = Str::plural($model_name[1]);
                $plural = str_replace("-", "_", $plural);
                $columns = Schema::getColumnListing($plural);
                $columns = array_diff($columns, $columns_excluded);
                $body['raw'] = $this->setBodyFromCollumns($columns, $plural);
            }
        }


        return $body;
    }


    public function setBodyFromCollumns($columns, $schema_name): bool|string
    {
        $items = [];
        foreach ($columns as $column) {
            if (str_contains($column, "_id"))
                $items = array_merge($items, [$column => '{{INT10}}']);
            else {
                $column_definitions = Schema::getColumns($schema_name);
                $column_filtered = $this->same_name($column_definitions, $column);
                $column_name = Str::lower($column_filtered['type_name']);
                if ($column_filtered['name'] == 'email') {
                    $items = array_merge($items, [$column => '{{$randomExampleEmail}}']);
                } elseif (in_array($column_filtered['name'], ['phone', 'mobile'])) {
                    $items = array_merge($items, [$column => '{{$randomPhoneNumber}}']);
                } elseif ($column_name == 'varchar') {
                    preg_match_all("#\((.*?)\)#", $column_filtered['type'], $parts);
                    $size = (int)$parts[1][0];
                    if ($size <= 3)
                        $items = array_merge($items, [$column => '{{$randomCountryCode}}']);
                    elseif ($size <= 20)
                        $items = array_merge($items, [$column => '{{$randomWord}}']);
                    elseif ($size <= 50)
                        $items = array_merge($items, [$column => '{{$randomWords}}']);
                    elseif ($size <= 100)
                        $items = array_merge($items, [$column => '{{$randomLoremSentence}}']);
                    else
                        $items = array_merge($items, [$column => '{{$randomLoremParagraph}}']);
                } elseif ($column_name == 'text') {
                    $items = array_merge($items, [$column => '{{$randomLoremText}}']);
                } elseif ($column_name == 'double') {
                    $items = array_merge($items, [$column => '{{$randomInt}}.{{INT10}}']);
                } elseif ($column_name == 'tinyint') {
                    $items = array_merge($items, [$column => '{{BOOLEAN}}']);
                } elseif ($column_name == 'bigint') {
                    $items = array_merge($items, [$column => '{{$randomInt}}']);
                } elseif ($column_name == 'int') {
                    $items = array_merge($items, [$column => '{{$randomInt}}']);
                } else {
                    $items = array_merge($items, [$column => '']);
                }
            }
        }


        return json_encode($items);
    }

    function same_name($all_columns, $item)
    {
        foreach ($all_columns as $column) {
            if ($column['name'] == $item) {
                return $column;
            }
        }
        return null;
    }

}
