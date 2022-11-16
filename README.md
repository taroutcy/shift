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

## 内容

### テーブル
以下は使用したテーブルの構成です．  
<img src="https://user-images.githubusercontent.com/38804704/202069131-84c96517-2df5-4c7e-9fd8-094f13a09ce8.jpg">

各テーブルの内容は以下の通りです．
| テーブル名 | 説明 | 子テーブル |　親テーブル |
|:---|:---|:---|:---|
| roles | 従業員の契約状況の種類 |  | users |
| departments | 従業員の部署の種類 | | users |
| users | 従業員の情報を保存 | roles, departments | schedules |<img width="301" alt="スクリーンショット 2022-11-16 15 30 36" src="https://user-images.githubusercontent.com/38804704/202101727-12691a1c-b684-4f7f-9751-37225df1f5d2.png">

| shifts | シフトの開始・終了時間の種類 |  | schedules | 
| schedule_statuses | シフトの提出状況の種類 |  | schedules |
| work_statuses | 出勤状況の種類 |  | schedules | 
| schedules | 提出・完了されたシフトの保存 | users, shifts, schedule_statuses, work_statuses |  |

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
| user_id | usersテーブルのid |
| shift_id | shiftsテーブルのid |
| schedule_status_id | schedule_statusesテーブルのid |
| work_status_id | work_statusesテーブルのid |
| date | 提出・完了されたシフトの日付 |
</details>

### 仕様
10桁の個人番号とパスワードを入力するとログインできます．
<img src="https://user-images.githubusercontent.com/38804704/202087193-1abd4a61-3a83-4905-ae1f-643655a9ad83.png">

ログイン後は編集権限の有無によって表示画面が変わります．(左:編集権限有, 右:編集権限無)
<p style="align-items: center">
<img width="502" src="https://user-images.githubusercontent.com/38804704/202088481-ef8068ee-f618-49e1-9d7c-5eae7bfc2f13.png">
<img width="300" src="https://user-images.githubusercontent.com/38804704/202088658-4be18be2-f383-4366-bb74-db12839735d9.png">
</p>
編集権限があるユーザはシフトの提出・確認に加えて<b>シフトの作成とユーザの管理</b>を行うことができます．

シフトの提出画面は以下のカレンダー形式で行うことができます．日付の中をクリックするとモーダルが表示されシフトを選択することができます．
<p style="align-items: center">
<img width="460" src="https://user-images.githubusercontent.com/38804704/202098044-12f6ee2e-e3c3-4f2a-80fe-54f8e3854fca.png">
<img width="482" width="539" src="https://user-images.githubusercontent.com/38804704/202101571-0dc2ec5b-48d7-4374-a63b-229dc20e0999.png">
</p>

出勤・欠勤・有給のいずれかを選択し，OKを押すとカレンダー一覧に提出したシフトが反映される．
<img width="544" src="https://user-images.githubusercontent.com/38804704/202101766-abaca196-2e4f-4c5f-a2e6-a258f1b06328.png">

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
