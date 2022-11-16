# シフト管理アプリ


<!-- START doctoc -->
<!-- END doctoc -->

## 説明
バイトのシフトを管理するアプリです．  
管理者(店長)はシフトの提出と確認，ユーザの新規登録と編集を行うことができます．  
スタッフはシフトの提出と確認のみを行うことができます．  

## デモ
<a href="https://salty-ravine-24071.herokuapp.com/">デモ</a>で試すことができます．

管理者  
個人番号: 0000000000  
パスワード: admin  

スタッフ  
個人番号: 1111111111  
パスワード: staff  

## 特徴

### テーブル
以下は使用したテーブルの構成です．  
![table](https://user-images.githubusercontent.com/38804704/202069131-84c96517-2df5-4c7e-9fd8-094f13a09ce8.jpg)

各テーブルの内容は以下の通りです．
| テーブル名 | 説明 | 子テーブル |　親テーブル |
|:---|:---|:---|:---|
| roles | 従業員の契約状況の種類 |  | users |
| departments | 従業員の部署の種類 | | users |
| users | 従業員の情報を保存 | roles, departments | schedules |
| shifts | シフトの開始・終了時間の種類 |  | schedules | 
| schedule_statues | シフトの提出状況の種類 |  | schedules |
| work_statues | 出勤状況の種類 |  | schedules | 
| schedules | 提出・完了されたシフトの保存 | users, shifts, schedule_statues, work_statues |  |

主テーブル(users, schedules)におけるカラムの詳細は以下の通りです．
<details>
<summary><b>users</b></summary>

| カラム名 | 説明 |
|:---|:---|
| role_id | roleテーブルのid |
| department_id | departmentsテーブルのid |
| last_name | 苗字 |
| first_name | 名前 | 
| number | 個人番号 |
| password | パスワード | 
| active | 勤務可否 |
| editor | 編集権限の有無 |
</details>

<details>
<summary><b>schedules</b></summary>

| カラム名 | 説明 |
|:---|:---|
| user_id | userテーブルのid |
| shift_id | shiftsテーブルのid |
| schedule_status_id | schedule_statusesテーブルのid |
| work_status_id | work_statusesテーブルのid |
| date | 提出・完了されたシフトの日付 |
</details>

### 仕様

## ToDo
- [ ] ユーザの削除機能
- [ ] ユーザのアクティブ状態の編集機能
- [ ] ユーザに対する管理者権限の編集機能
- [ ] シフト提出時に注意事項把握のための入力項目の追加
- [ ] 提出したシフトを管理者が編集する機能
- [ ] 管理者が確定させたシフトの閲覧機能
- [ ] スマートフォン上での表示

## 必要要件

## 利用方法

## インストール

## ライセンス

[MIT](https://github.com/tcnksm/tool/blob/master/LICENCE)

## 作者

[tcnksm](https://github.com/tcnksm)
