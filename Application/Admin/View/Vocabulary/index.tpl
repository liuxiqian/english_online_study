<extend name="Base:index" />
<block name="title">
	词汇管理
</block>
<block name="body">

<div class="col-md-2">
		<div class="form-group">
			<select name="type" class="form-control">
				<option value="all">选择课程</option>
				<option value="uploaded" <eq name="type" value="uploaded">selected="selected"</eq>>七年级上</option>
				<option value="toupload" <eq name="type" value="toupload">selected="selected"</eq>>七年级下</option>
				<option value="reviewed" <eq name="type" value="reviewed">selected="selected"</eq>>八年级上</option>
				<option value="reviewing" <eq name="type" value="reviewing">selected="selected"</eq>>八年级下</option>
			</select>
		</div>
	</div>
<div class="col-md-1">
	<a class="button btn btn-info"  href="" ><i class="fa fa-search"></i> 搜索</a>
</div>
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>序号</th>
				<th>词汇</th>
				<th>组测试</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>significant</td>
				<td><a class="btn btn-success" href="{:U('edit')}"><i class="fa fa-pencil"></i>&nbsp;确认</a></td>
			</tr>

		</tbody>
	</table>
</block>
