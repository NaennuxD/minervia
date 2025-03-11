<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\User;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    View::composer('*', function($view)
    {
      if (Auth::check()){
        
        $user = User::where('id', '=', Auth::id())->first(['funcao']);

        if($user){
          $menu = '';

          if($user->funcao == 'administrador'){
            $menu = 'resources/menu/verticalMenuAdministrador.json';
          }elseif($user->funcao == 'aprovador'){
            $menu = 'resources/menu/verticalMenuAprovador.json';
          }elseif($user->funcao == 'operador'){
            $menu = 'resources/menu/verticalMenuOperador.json';
          }else{
            abort('401');
          }
          
          $verticalMenuJson = file_get_contents(base_path($menu));
          $verticalMenuData = json_decode($verticalMenuJson);
          \View::share('menuData', [$verticalMenuData]);
        }else{
          return redirect(route('login'));
        }

      }else{
        return redirect(route('login'));
      }
    });
  }
}