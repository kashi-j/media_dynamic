This is a media site created as a dynamic site.
Also, this site is created using CMS.

# Wordpress の環境構築手順

プラグイン(wp-content/plugins/_)やメディア画像(wp-content/upload/_)は Git 管理が煩雑になる他、後で説明するプラグインを介してインストールすることを想定しているため、Git の管理していない。

## 1.wordpress のインストール

任意のツール（以下に例をあげた）のいずれかを使用して、wordpress 環境を構築する。（各ツールの使用方法は割愛）

- xampp/mamp
- local(旧:local by flywheel)
- vagrant
- docker

## 2.仮のサイト情報を設定する

任意のツールで Wordpress をインストール後、言語設定や任意のユーザ名、パス、サイト情報を登録し、管理画面へアクセスする.  
※後述するバックアップファイルのインポートでこの設定内容は上書きされるので、仮のものと考えて良い。

## 3.プラグインのインストール

管理画面左ペインより、「プラグイン(plugin)」を選択し、「新規プラグインを追加」で「all in one wp-migration」を検索、インストール、有効化する

## 4.バックアップファイルのインポート

DB、メディア、プラグイン、記事情報等を含んだバックアップファイルをダウンロードしておき、「All-in-one WP Migration」>> 「インポート」でファイル指定する。  
※このバックアップファイルにテーマファイルが含まれていると、theme 配下の.git が消えてしまうため、バックアップファイルにテーマファイルは含めないこと。

## 5.再ログイン

インポート完了後にブラウザを再読み込みすると、ログイン画面にリダイレクトされるのでユーザ名、パスワードを入力する。  
※「手順 2」で設定したユーザ名、パスワードはバックアップファイルにより上書かれた後、使えなくなります。  
ログイン後、各ページが問題なく表示できていれば環境構築は完了

<br>
<br>
<br>

# バックアップファイルの作成

プラグイン情報やフィールドの追加など、DB まわりの修正が行われた場合は、バックアップファイルもgitに反映すること。

◾️ バックアップファイルの作成  
1.「All-in-one WP Migration」>> 「エクスポート」  
2.「高度なオプション」より「テーマをエクスポートしない」にチェックをいれる  
※テーマ配下のコードは Git で取得可能かつ BP ファイルのインストール先で.git を上書いて消してしまうため、エクスポート対象からテーマを外すこと。  
3.生成した BP ファイルをgit管理下へ残す。

<br>
# 静的生成
github pagesによる公開をするため、static press 2019による静的生成を実施し、生成ファイルは下記リポジトリで管理する。  

https://github.com/kashi-j/media_static  

公開ページ：
https://kashi-j.github.io/media_static/

![screencapture-kashi-j-github-io-media-static-2024-03-24-15_23_43 (1)](https://github.com/kashi-j/media_static/assets/69555348/59ae3efd-7f0b-40cc-ac5c-60605667768f)
