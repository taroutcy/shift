# シフト管理アプリ


<!-- START doctoc -->
<!-- END doctoc -->

## 説明
バイトのシフトを管理するアプリです．  
管理者(店長)はシフトの提出と確認，従業員の新規登録と編集を行うことができます．  
スタッフはシフトの提出と確認のみを行うことができます．  

## デモ
<a href="https://desolate-sea-27640.herokuapp.com/">こちら</a>で試すことができます．

管理者  
個人番号: 0000000000  
パスワード: admin  

スタッフ  
個人番号: 1111111111  
パスワード: staff  

## 内容

### テーブル
以下は使用したテーブルの構成です．  
<img width="600" src="https://user-images.githubusercontent.com/38804704/202069131-84c96517-2df5-4c7e-9fd8-094f13a09ce8.jpg">

各テーブルの内容は以下の通りです．
| テーブル名 | 説明 | 子テーブル |　親テーブル |
|:---|:---|:---|:---|
| roles | 従業員の契約状況の種類 |  | users |
| departments | 従業員の部署の種類 | | users |
| users | 従業員の情報を保存 | roles, departments | schedules | | 
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

## 仕様
10桁の個人番号とパスワードを入力するとログインできます．

<img width="450" src="https://user-images.githubusercontent.com/38804704/221360809-d20f48b7-203f-4b98-a629-d139001d3339.png" title="login">

ログイン後は編集権限の有無によって表示画面が変わります．(左:編集権限有, 右:編集権限無)
<p style="align-items: center">
<img width="450" src="https://user-images.githubusercontent.com/38804704/202088481-ef8068ee-f618-49e1-9d7c-5eae7bfc2f13.png" title="home with edit">
<img width="268" src="https://user-images.githubusercontent.com/38804704/202088658-4be18be2-f383-4366-bb74-db12839735d9.png">
</p>
編集権限があるユーザはシフトの提出・確認に加えて<b>シフトの作成とユーザの管理</b>を行うことができます．

### シフト提出
シフトの提出は以下のカレンダー形式で行うことができます．日付の中をクリックするとモーダルが表示されシフトを選択することができます．
<p style="align-items: center">
<img width="460" src="https://user-images.githubusercontent.com/38804704/221360858-6060915a-e680-4884-9446-b4c8a9557437.png">
<img width="539" src="https://user-images.githubusercontent.com/38804704/202591562-8ef51339-35fe-4a3e-978f-c069e554ad61.png">
</p>

出勤・欠勤・有給のいずれかを選択し，OKを押すとカレンダー一覧に提出したシフトが反映されます．
<img width="400" src="https://user-images.githubusercontent.com/38804704/202110586-8f889419-e3d4-44f5-b29a-a5ded4c6ef32.png">

### シフトの確認
シフト提出されたは以下のように確認することができます．
<img width="800" src="https://user-images.githubusercontent.com/38804704/221360915-17f5e9b5-65e9-4a86-a326-d027c593ef86.png">

### シフト作成
シフト作成は編集権限を持つユーザのみ行うことができます．
ロックボタンでシフトをロック，解除ボタンで提出を許可することができます．
シフトをロックすると全従業員のシフトを調整することができます．
<img width="800" src="https://user-images.githubusercontent.com/38804704/221360970-4cdf6b47-7840-4af5-8c5f-cc23c96f2783.png">

以下のように編集者は提出されたシフトを調整して登録することができます．
<img width="800" src="https://user-images.githubusercontent.com/38804704/221362746-55151eea-ee67-4f3d-81e7-c602d0c94ed6.png">

### 従業員管理
従業員管理は編集権限を持つユーザが以下の画面で行うことができます．
<img width="600" src="https://user-images.githubusercontent.com/38804704/221363619-643f0707-a581-4eac-8e17-c1ce68aeb023.png">

ユーザをクリックすると編集画面へ飛び，氏名，契約状況，デパ(役割)を変更することができます．
<img width="600" src="https://user-images.githubusercontent.com/38804704/221363690-25fc171d-8ca5-428a-afc0-081855d74e5c.png">

以下が新規登録画面です．各項目を埋めることで新たなユーザを登録することができます．
<img width="600" src="https://user-images.githubusercontent.com/38804704/221363723-d04b1bbe-40f8-4caa-ad19-83c90f675062.png">

## ToDo
- [ ] ユーザの削除機能
- [ ] ユーザのアクティブ状態の編集機能
- [ ] ユーザに対する管理者権限の編集機能
- [ ] シフト提出時に注意事項把握のための入力項目の追加
- [x] 提出したシフトを管理者が編集する機能
- [x] 管理者が確定させたシフトの閲覧機能
- [ ] スマートフォン上での表示

## 必要要件

## 利用方法

## インストール

## ライセンス

## 作者

[taroutcy](https://github.com/taroutcy)
