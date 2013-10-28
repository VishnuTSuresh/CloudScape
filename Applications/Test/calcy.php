<!DOCTYPE html>
<?php 
$c=0;
$a=0;
$q=1;
?>
<html>
<head>
<body>
<?php
if(isset($_request['equal'])==false || $q!=0)
{
if(isset($_request['equal'])==false)
{
if(isset($_request['one']))
$v[$c]=1;
if(isset($_request['two']))
$v[$c]=2;
if(isset($_request['three']))
$v[$c]=3;
if(isset($_request['four']))
$v[$c]=4;
if(isset($_request['five']))
$v[$c]=5;
if(isset($_request['six']))
$v[$c]=6;
if(isset($_request['seven']))
$v[$c]=7;
if(isset($_request['eight']))
$v[$c]=8;
if(isset($_request['nine']))
$v[$c]=9;
if(isset($_request['zero']))
$v[$c]=0;
if(isset($_request['add']))
$v[$c]='+';
if(isset($_request['sub']))
$v[$c]='-';
if(isset($_request['mul']))
$v[$c]='*';
if(isset($_request['div']))
$v[$c]='/';
?>
<form action="calcy.php" method="post">
<table border="1">
<tr>
<td><input type="submit" name="one" value="1"></td>
<td><input type="submit" name="two" value="2"></td>
<td><input type="submit" name="three" value="3"></td>
</tr>
<tr>
<td><input type="submit" name="four" value="4"></td>
<td><input type="submit" name="five" value="5"></td>
<td><input type="submit" name="six" value="6"></td>
</tr>
<tr>
<td><input type="submit" name="seven" value="7"></td>
<td><input type="submit" name="eight" value="8"></td>
<td><input type="submit" name="nine" value="9"></td>
</tr>
<tr>
<td><input type="submit" name="zero" value="0"></td>
<td><input type="submit" name="add" value="+"></td>
<td><input type="submit" name="sub" value="-"></td>
</tr>
<tr>
<td><input type="submit" name="mul" value="*"></td>
<td><input type="submit" name="div" value="/"></td>
<td><input type="submit" name="equal" value="="></td>
</tr>
<?php
if($v[$c]!='+'||$v[$c]!='-'||$v[$c]!='*'||$v[$c]!='/'&&$a==0)
$x[$c]=$v[$c];
else
{
$o=$v[$c];
if($a!=0)
$y[$a-1]=$v[$c];
$a++;
}
?>
}
<tr>
<td colspan="3" rowspan="3">
<?php
if(isset($_REQUEST["equal"]))
{
$d=1;$n1=0;$n2=0;$q=0;
for($i=0;$i<count($a);$i++)
{
for($j=0;$j<$i;$j++)
$d=$d*10;
$n1=$n1+($a[$i]*$d);
}
$d=1;
for($i=0;$i<count($b);$i++)
{
for($j=0;$j<$i;$j++)
$d=$d*10;
$n2=$n2+($b[$i]*$d);
}
if($o=='+')
$ans=$n1+$n2;
if($o=='-')
$ans=$n1+$n2;
if($o=='*')
$ans=$n1+$n2;
if($o=='/')
$ans=$n1+$n2;
echo $ans;
}
else 
echo $v[$c];
?>
</td>
</tr>
<tr>
</tr>
<tr>
</tr>
</table>
</form>
<?php 
}}
?>
</body>
</html>