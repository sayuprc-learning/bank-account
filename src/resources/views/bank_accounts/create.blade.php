<form action="/create" method="post">
    @csrf
    口座番号: <input type="text" name="account_number"><br>
    入金額: <input type="number" name="amount"><br>
    <input type="submit" value="登録">
</form>
