-- 大文字小文字区別のため、照合順序をbin系(utf8_bin)に変更する
-- １・２は、XSERVERではGUIで実施　
-- １．DBのデフォルト値を変更する
-- 　　DB選択して「操作」タブ内の照合順序を変更・実行
-- ２．テーブルごとのデフォルト値を変更する
-- 　　テーブル選択して「操作」タブ内のテーブルオプションの照合順序を変更・実行
-- ３．カラムのColllationを変更する
-- 　　以下のSQLで文字列型のカラムに対してALTERを実行する
-- 　　必要なカラムは以下のSHOWで確認できる
-- 　　show full columns from [table];
-- ４．照合順序を変更した上でUNIQUEを追加する
-- 　　ここで重複あれば適宜削除する

-- 外部キーのせいで変更できないため、外す
ALTER TABLE notes DROP FOREIGN KEY notes_fk;
ALTER TABLE note_items DROP FOREIGN KEY note_items_fk;
ALTER TABLE users_groups DROP FOREIGN KEY users_groups_fk;
ALTER TABLE users_groups DROP FOREIGN KEY users_groups_fk_1;

-- Cllation変更
ALTER TABLE note_items CONVERT TO CHARACTER SET utf8 COLLATE 'utf8_bin';
ALTER TABLE users_groups CONVERT TO CHARACTER SET utf8 COLLATE 'utf8_bin';
ALTER TABLE notes CONVERT TO CHARACTER SET utf8 COLLATE 'utf8_bin';
ALTER TABLE groups CONVERT TO CHARACTER SET utf8 COLLATE 'utf8_bin';
ALTER TABLE password_resets CONVERT TO CHARACTER SET utf8 COLLATE 'utf8_bin';
ALTER TABLE users CONVERT TO CHARACTER SET utf8 COLLATE 'utf8_bin';

-- 外部キーを再度追加する
ALTER TABLE note_items ADD FOREIGN KEY note_items_fk(group_id, note_id) REFERENCES notes(group_id, note_id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE users_groups ADD FOREIGN KEY users_groups_fk(user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE users_groups ADD FOREIGN KEY users_groups_fk_1(group_id) REFERENCES groups(group_id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE notes ADD FOREIGN KEY notes_fk(group_id) REFERENCES groups(group_id) ON UPDATE CASCADE ON DELETE CASCADE;

-- UNIQUE追加
ALTER TABLE groups ADD CONSTRAINT groups_un UNIQUE (group_name);
