<?php if (!defined('THINK_PATH')) exit();?><table>
<tr>
<td>姓名：</td>
<td>年龄：</td>
<td>性别：</td>
<td>身份证：</td>
<td>电话：</td>
<td>日期：</td>
<td>时间：</td>
<td>状态：</td>
</tr>
<?php if(is_array($orderList)): $i = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr>
	<td><?php echo ($order["name"]); ?></td>
	<td><?php echo ($order["age"]); ?></td>
	<td><?php echo ($order["sex"]); ?></td>
	<td><?php echo ($order["identifier"]); ?></td>
	<td><?php echo ($order["tel"]); ?></td>
	<td><?php echo ($order["date"]); ?></td>
	<td><?php echo ($order["time"]); ?></td>
	<td><?php echo (checkStatus($order["status"])); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>