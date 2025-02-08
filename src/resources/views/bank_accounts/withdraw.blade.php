@php use Shared\Route\Web\RouteMap; @endphp

<form action="{{ route(RouteMap::Withdraw) }}" method="post">
    @csrf
    引き落とし先口座番号: <input type="text" name="account_number"><br>
    引き落とし額: <input type="number" name="amount"><br>
    <input type="submit" value="引き落とし">
</form>
