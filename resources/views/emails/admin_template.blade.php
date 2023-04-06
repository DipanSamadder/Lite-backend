<!DOCTYPE html>
<html>
<head>
    <title>{{ $content['title'] }}</title>
</head>
<body>
    <h5>User Leads Deails</h5>
    @php
        foreach(json_decode($content['body'], true) as $key => $value){
            foreach($value as $k => $v){
                echo '<b>'.ucfirst(str_replace('_', ' ',$k))."</b> :- ".$v."<br>";
            }
        }
    @endphp
</body>
</html>