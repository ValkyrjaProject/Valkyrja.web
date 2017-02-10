<!DOCTYPE html>
<html>
    <body>
        <form method="POST" action="/config/editt/update">
            {{ csrf_field() }}
            <input type="submit">
        </form>
    </body>
</html>
