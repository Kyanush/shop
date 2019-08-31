<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8"/>
    </head>
<body>

    <table>
        <thead>
            <tr>
                @foreach($tableColumns as $column)
                    <td>{{ $column['column'] }}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
                <tr>
                    @foreach($tableColumns as $column)
                        <td>{{ $item->{$column['column']} }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</body>




