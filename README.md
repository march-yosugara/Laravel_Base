# Laravel_Base
プロトタイプ基盤

## インストール

    前提：Composerインストール済み

~~~ bash
composer create-project "laravel/laravel=7.*" laravel_base
~~~

## HomeStead

### VirtualBox

[ダウンロード](https://www.virtualbox.org/wiki/Downloads)  

### Vagrant

[ダウンロード](https://www.vagrantup.com/downloads.html)  

### Add Box

~~~ bash
# コマンド実行後、使用する仮想環境ツールを選択する
vagrant box add laravel/homestead
~~~

### Clone HomeStead

~~~ bash
# Clone
git clone https://github.com/laravel/homestead.git

# Checkout release-blanch
cd homestead
git checkout release
~~~

### Create yaml

~~~ bash
# At homestead directory
init.bat
~~~

### 共有フォルダ

上がローカル、下がHomestead内  
~~~ yaml
folders:
    - map: ./shared
      to: /home/vagrant/shared

sites:
    - map: homestead.test
      to: /home/vagrant/shared/laravel_base/public
~~~

### ポートフォワード

~~~bash
# http://localhost:8080でアクセスする
ssh homestead -L 8080:localhost:8000
~~~

## Auth機能

### 準備

~~~bash
composer require laravel/ui "^2.0"
php artisan ui vue --auth
~~~

### DB

~~~ini
; 以下の設定はHomesteadでデフォルトで用意されているPostgreSQL
; ローカルからはport:54320でポートフォワードされている
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=homestead
DB_PASSWORD=secret
~~~

### NPM

- package.json  

  ~~~json
  // cross-envの設定が要変更
  "scripts": {
    "dev": "npm run development",
    "development": "cross-env NODE_ENV=development node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js",
    "watch": "npm run development -- --watch",
    "watch-poll": "npm run watch -- --watch-poll",
    "hot": "cross-env NODE_ENV=development node_modules/webpack-dev-server/bin/webpack-dev-server.js --inline --hot --config=node_modules/laravel-mix/setup/webpack.config.js",
    "prod": "npm run production",
    "production": "cross-env NODE_ENV=production node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js"
  },
  ~~~

- コマンド  

  ~~~bash
  # 一連のコマンドがエラー無く通るまで調整する
  # sudoで実行する・キャッシュクリア等
  rm -rf node_modules
  npm install --no-bin-links
  npm run dev
  ~~~

- コマンド(開発中)  

  ~~~bash
  npm run watch
  ~~~

## サーバデプロイ

レンタルサーバは「**エックスサーバー**」を選択  
サポートしているDBは「*MYSQL*」になるため、構築SQL作成時に注意。  
(型以外はほぼ同じ)  

### 参考

[エックスサーバー](https://www.xserver.ne.jp/)  
[デプロイその１](https://qiita.com/n_oshiumi/items/2a1cc7d147ee1eff3e23)  
[デプロイその２](https://naoya-ono.com/blog/deploy-laravel-xserver/)  

### SSH

C:\Users\yosug\.ssh

~~~bash
# SSH接続
ssh -l march23y -i C:\Users\yosug\.ssh\march23y.key march23y.xsrv.jp -p 10022
~~~

### MYSQL

~~~bash
mysql -h mysql10073.xserver.jp -u march23y_larabs -p march23y_laravelbase
~~~

~~~bash
mysql -h 103.141.96.209 -u march23y_larabs -p march23y_laravelbase < laravelbase_ddl.sql
~~~

~~~ bash
source laravelbase_ddl.sql
~~~
