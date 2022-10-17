
<table class="table">
    <tr>
        <th class="text-right">個人番号</th>
        <td>{{ Auth::user()->number }}</td>
    </tr>
    <tr>
        <th class="text-right">氏名</th>
        <td>{{ Auth::user()->last_name }}　{{ Auth::user()->first_name }}</td>
    </tr>
    <tr>
        <th class="text-right">契約状況</th>
        <td>{{ App\Models\Role::where('id', '=', Auth::user()->role_id)->first()->name }}</td>
    </tr>
    <tr>
        <th class="text-right">デパ</th>
        <td>{{ App\Models\Department::where('id', '=', Auth::user()->department_id)->first()->name }}</td>
    </tr>
</table>
