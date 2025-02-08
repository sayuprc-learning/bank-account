@php use Shared\Route\Web\RouteMap; @endphp

<form action="{{ route(RouteMap::Transfer) }}" method="post">
    @csrf
    振込元口座番号: <input type="text" name="from_account_number"><br>
    振込先口座番号: <input type="text" name="to_account_number"><br>
    振込金額: <input type="number" name="amount"><br>
    <input type="submit" value="振込">
</form>
