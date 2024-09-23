<?php

namespace AyatKyo\Klorovel\Core\Mixins\Router;

use Illuminate\Routing\Router;
use Illuminate\Support\Str;

class KlorovelResource
{
    protected $router;
    protected $registered = false;

    protected $name;
    protected $controller;
    protected $options = [
        'modal' => true,
        'tambahan' => []
    ];

    public function __construct(Router $router, $name, $controller, array $options)
    {
        $this->router = $router;
        $this->name = $name;
        $this->controller = $controller;
        $this->options = array_merge($this->options, $options);
    }

    public function only($methods)
    {
        $this->options['only'] = is_array($methods) ? $methods : func_get_args();
        return $this;
    }

    public function middleware($middleware)
    {
        $this->options['middleware'] = is_array($middleware) ? $middleware : [$middleware];
        return $this;
    }

    public function get($uri, $method = null, $name = null)
    {
        $this->options['tambahan']['GET'][] = (object) [
            "uri" => $uri,
            "method" => $method,
            "name" => $name,
        ];
        return $this;
    }

    public function post($uri, $method = null, $name = null)
    {
        $this->options['tambahan']['POST'][] = (object) [
            "uri" => $uri,
            "method" => $method,
            "name" => $name,
        ];
        return $this;
    }

    public function put($uri, $method = null, $name = null)
    {
        $this->options['tambahan']['PUT'][] = (object) [
            "uri" => $uri,
            "method" => $method,
            "name" => $name,
        ];
        return $this;
    }

    public function delete($uri, $method = null, $name = null)
    {
        $this->options['tambahan']['DELETE'][] = (object) [
            "uri" => $uri,
            "method" => $method,
            "name" => $name,
        ];
        return $this;
    }

    //  TODO handle only dan group
    public function register()
    {
        $this->registered = true;

        //  TODO Sementara Manual dulu
        $name = Str::replace('/', '.', $this->name);
        $uri = Str::replace('.', '/', $this->name);

        $ctrl = $this->controller . '@';
        $router = $this->router;
        $options = $this->options;
        $me = $this;
        $groupOption = [
            'prefix' => $options['prefix'] ?? $uri,
            'as' => $name . '.',
        ];

        if (isset($options['middleware'])) {
            $groupOption['middleware'] = $options['middleware'];
        }

        $this->router->group($groupOption, function () use ($me, $ctrl, $router, $options) {
            $router->get('/', "{$ctrl}index")->name('index');
            $router->post('datatable', "{$ctrl}datatable")->name('datatable');
            $router->get('tambah', "{$ctrl}create")->name('create');
            
            //  Jika pakai modal
            if ($options['modal']) {
                $router->post('ubah', "{$ctrl}edit")->name('edit');
            } else {
                $router->get('{id}/ubah', "{$ctrl}edit")->name('edit');
            }

            $router->post('/', "{$ctrl}store")->name('store');
            $router->put('/', "{$ctrl}update")->name('update');
            $router->delete('/', "{$ctrl}destroy")->name('destroy');

            //  Jika ada tambahan
            if (isset($options['tambahan']) && count($options['tambahan'])) {
                $me->prosesTambahan();
            }
        });
    }

    public function prosesTambahan()
    {
        $ctrl = $this->controller . '@';
        $tambahanList = $this->options['tambahan'];

        //  yang sering dipakai saja
        foreach (["get", "post", "put", "delete"] as $httpKata) {
            $httpKataUpper = strtoupper($httpKata);
            if (isset($tambahanList[$httpKataUpper]) && count($tambahanList[$httpKataUpper])) {
                foreach ($tambahanList[$httpKataUpper] as $item) {
                    //  Jika tidak ada method
                    if (! isset($item->method)) {
                        $item->method = Str::camel($httpKata . '_' . $item->uri);
                    }

                    //  Jika tidak ada nama
                    if (! isset($item->name)) {
                        $item->name = $item->uri;
                    }

                    $this->router->{$httpKata}($item->uri, $ctrl . $item->method)
                        ->name($item->name);
                }
            }
        }
    }


    
    public function __destruct()
    {
        if (! $this->registered) {
            $this->register();
        }
    }
}
