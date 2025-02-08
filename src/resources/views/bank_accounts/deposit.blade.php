@php use Shared\Route\Web\RouteMap; @endphp

<form action="{{ route(RouteMap::Deposit) }}" method="post">
    @csrf
    入金先口座番号: <input type="text" name="account_number"><br>
    入金額: <input type="number" name="amount"><br>
    <input type="submit" value="入金">
</form>
