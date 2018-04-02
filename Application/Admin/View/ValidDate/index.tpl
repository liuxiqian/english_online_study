<extend name="Base:index" />
<block name="title">
	有效期管理
</block>
<block name="body">
<div class="col-md-2">
	<div class="form-group">
		<select name="type" class="form-control">
			<option value="all">选择有效期</option>
			<option value="uploaded" <eq name="type" value="uploaded">selected="selected"</eq>>第一学期</option>
			<option value="toupload" <eq name="type" value="toupload">selected="selected"</eq>>第二学期</option>
			<option value="reviewed" <eq name="type" value="reviewed">selected="selected"</eq>>第三学期</option>
			<option value="reviewing" <eq name="type" value="reviewing">selected="selected"</eq>>第四学期</option>
		</select>
	</div>
</div>
<div class="col-md-1">
	<a class="button btn btn-info"  href="" ><i class="glyphicon glyphicon-search"></i>查询</a>
</div>

	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>组号</th>
				<th>卡号</th>
				<th>生成日期</th>
				<th>截止日期</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>38579596</td>
				<td>2016.1.30</td>
				<td>2016.3.1</td>
				<td><a class="btn btn-sm btn-primary" href="{:U('edit')}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                    <a class="btn btn-sm btn-danger" href="{:U('edit')}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></td>

			</tr>
			<tr>
				<td>2</td>
				<td>38579596</td>
				<td>2016.1.30</td>
				<td>2016.3.1</td>
				<td><a class="btn btn-sm btn-primary" href="{:U('edit')}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                    <a class="btn btn-sm btn-danger" href="{:U('edit')}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></td>
			</tr>
			<tr>
				<td>3</td>
				<td>38579596</td>
				<td>2016.1.30</td>
				<td>2016.3.1</td>
				<td><a class="btn btn-sm btn-primary" href="{:U('edit')}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                    <a class="btn btn-sm btn-danger" href="{:U('edit')}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></td>
			</tr>
			<tr>
				<td>4</td>
				<td>38579596</td>
				<td>2016.1.30</td>
				<td>2016.3.1</td>
				<td><a class="btn btn-sm btn-primary" href="{:U('edit')}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                    <a class="btn btn-sm btn-danger" href="{:U('edit')}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></td>
			</tr>
			<tr>
				<td>5</td>
				<td>38579596</td>
				<td>2016.1.30</td>
				<td>2016.3.1</td>
				<td><a class="btn btn-sm btn-primary" href="{:U('edit')}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                    <a class="btn btn-sm btn-danger" href="{:U('edit')}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></td>
			</tr>
			<tr>
				<td>6</td>
				<td>38579596</td>
				<td>2016.1.30</td>
				<td>2016.3.1</td>
				<td><a class="btn btn-sm btn-primary" href="{:U('edit')}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                    <a class="btn btn-sm btn-danger" href="{:U('edit')}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></td>
			</tr>
			<tr>
				<td>7</td>
				<td>38579596</td>
				<td>2016.1.30</td>
				<td>2016.3.1</td>
				<td><a class="btn btn-sm btn-primary" href="{:U('edit')}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                    <a class="btn btn-sm btn-danger" href="{:U('edit')}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></td>
			</tr>
			<tr>
				<td>8</td>
				<td>38579596</td>
				<td>2016.1.30</td>
				<td>2016.3.1</td>
				<td><a class="btn btn-sm btn-primary" href="{:U('edit')}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                    <a class="btn btn-sm btn-danger" href="{:U('edit')}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></td>
			</tr>

			
		</tbody>
	</table>

	共8条 【首页|上一页|下一页|尾页】第一页 转到 <input type="text" style="width: 50px">页 <button>go</button> 共1页 每页50条
</block>