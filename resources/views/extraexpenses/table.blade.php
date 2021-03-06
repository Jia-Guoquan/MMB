<?php usort($tableGrid, "\App\Library\SiteHelpers::_sort"); ?> <div class="col-md-12">
<div class="box box-primary">
	<div class="box-header with-border">

		@include( 'mmb/toolbar')
	</div>
	<div class="box-body">



	 {!! (isset($search_map) ? $search_map : '') !!}

	 <?php echo Form::open(array('url'=>'extraexpenses/delete/', 'class'=>'form-horizontal' ,'id' =>'MmbTable'  ,'data-parsley-validate'=>'' )) ;?>
<div class="table-responsive" style="min-height:300px; padding-bottom:60px; border: none !important">
	@if(count($rowData)>=1)
    <table class="table table-bordered table-striped " id="{{ $pageModule }}Table">
        <thead>
			<tr>
				<th width="20"> No </th>
				<th width="30"> <input type="checkbox" class="checkall" /></th>
				@if($setting['view-method']=='expand')<th width="30" style="width: 30px;">  </th> @endif
				<th width="60"><?php echo Lang::get('core.btn_action') ;?></th>
				<th>{{Lang::get('core.staffname')}}</th>
				<th>{{Lang::get('core.amount')}}</th>
				<th>{{Lang::get('core.paymenttype')}}</th>
				<th width="30">{{Lang::get('core.date')}}</th>
				<th>{{Lang::get('core.extraexpense')}}</th>
				<th>{{Lang::get('core.category')}}</th>
				<th>{{Lang::get('core.notes')}}</th>
				<th width="30">{{Lang::get('core.attached')}}</th>
			  </tr>
        </thead>

        <tbody>
        	@if($access['is_add'] =='1' && $setting['inline']=='true')
			<tr id="form-0" >
				<td> # </td>
				<td> </td>
				@if($setting['view-method']=='expand') <td> </td> @endif
				<td >
					<button onclick="saved('form-0')" class="btn btn-success btn-xs" type="button"><i class="fa fa-play-circle"></i></button>
				</td>
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
					<?php $limited = isset($t['limited']) ? $t['limited'] :''; ?>
						@if(\App\Library\SiteHelpers::filterColumn($limited ))
						<td data-form="{{ $t['field'] }}" data-form-type="{{ \App\Library\AjaxHelpers::inlineFormType($t['field'],$tableForm)}}">
							{!! \App\Library\SiteHelpers::transForm($t['field'] , $tableForm) !!}
						</td>
						@endif
					@endif
				@endforeach

			  </tr>
			  @endif

           		<?php foreach ($rowData as $row) :
           			  $id = $row->expenseID;
           		?>
                <tr class="editable" id="form-{{ $row->expenseID }}">
					<td class="number"> <?php echo ++$i;?>  </td>
					<td ><input type="checkbox" class="ids" name="ids[]" value="<?php echo $row->expenseID ;?>" />  </td>
					@if($setting['view-method']=='expand')
					<td><a href="javascript:void(0)" class="expandable" rel="#row-{{ $row->expenseID }}" data-url="{{ url('extraexpenses/show/'.$id) }}"><i class="fa fa-plus " ></i></a></td>
					@endif
				 <td data-values="action" style="width: 6%;" data-key="<?php echo $row->expenseID ;?>"  >
					{!! \App\Library\AjaxHelpers::buttonAction_expense('extraexpenses',$access,$id ,$setting) !!}
					{!! \App\Library\AjaxHelpers::buttonActionInline($row->expenseID,'expenseID') !!}

				</td>
					 <?php foreach ($tableGrid as $field) :
					 	if($field['view'] =='1') :
							$value = \App\Library\SiteHelpers::formatRows($row->{$field['field']}, $field , $row);
						 	?>

						 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
							 <?php if ($field['field'] == 'expenseID') {
										continue;
										}
										 ?>
						 	@if(\App\Library\SiteHelpers::filterColumn($limited ))

								 @if ($field['field'] == 'attached')
								 <td align="<?php echo $field['align'];?>" data-values="{{ $row->{$field['field']} }}" data-field="{{ $field['field'] }}" data-format="{{ htmlentities($value) }}">
								 <a href="{{asset('storage').'/files/'.($row->{$field['field']})}}" class="text-red" target="_blank"><i class="fa fa-file-pdf-o fa-2x"></i></a>
								 @elseif($field['field'] == 'staff')
								 <td align="<?php echo $field['align'];?>" data-values="{{ $row->{$field['field']} }}" data-field="{{ $field['field'] }}" data-format="{{ htmlentities($value) }}">
								 {{ \App\Http\Controllers\ExtraexpensesController::staff_name($value) }}

								 @elseif($field['field'] == 'currencyID')
									<!-- <td align="<?php echo $field['align'];?>" data-values="{{ $row->{$field['field']} }}" data-field="{{ $field['field'] }}" data-format="{{ htmlentities($value) }}"> -->
									<?php $currency_symbol = \App\Http\Controllers\ExtraexpensesController::currency_symbol($value) ?>
								 @elseif($field['field'] == 'cost')
										<td align="<?php echo $field['align'];?>" data-values="{{ $row->{$field['field']} }}" data-field="{{ $field['field'] }}" data-format="{{ htmlentities($value) }}">
										{!! $value !!} <?php echo($currency_symbol);?> 
								@elseif($field['field'] == 'paymenttypeID')
								<td align="<?php echo $field['align'];?>" data-values="{{ $row->{$field['field']} }}" data-field="{{ $field['field'] }}" data-format="{{ htmlentities($value) }}">
								{!! \App\Http\Controllers\ExtraexpensesController::paymenttypebyID($value) !!}
								@elseif($field['field'] == 'formula')
												<td align="<?php echo $field['align'];?>" data-values="{{ $row->{$field['field']} }}" data-field="{{ $field['field'] }}" data-format="{{ htmlentities($value) }}">
												@if($value == 1)
												{{ Lang::get('core.package') }}
												@else
												{{ Lang::get('core.simple') }}
												@endif

								@elseif($field['field'] == 'data')
										<td align="<?php echo $field['align'];?>" style="width:10%;" data-values="{{ $row->{$field['field']} }}" data-field="{{ $field['field'] }}" data-format="{{ htmlentities($value) }}">
										{!! $value !!}
								 @else
										<td align="<?php echo $field['align'];?>" data-values="{{ $row->{$field['field']} }}" data-field="{{ $field['field'] }}" data-format="{{ htmlentities($value) }}">
										{!! $value !!}
								 @endif

								 </td>
							@endif
						 <?php endif;
						endforeach;
					  ?>
                </tr>
                @if($setting['view-method']=='expand')
                <tr style="display:none" class="expanded" id="row-{{ $row->expenseID }}">
                	<td class="number"></td>
                	<td></td>
                	<td></td>
                	<td colspan="{{ $colspan}}" class="data"></td>
                	<td></td>
                </tr>
                @endif
            <?php endforeach;?>

        </tbody>

    </table>
	@else

	<div style="margin:100px 0; text-align:center;">

		<p> {{ Lang::get('core.norecord') }} </p>
	</div>

	@endif

	</div>
	<?php echo Form::close() ;?>
        @include('ajaxfooter')
	</div>
</div>

	</div>	 	                  			<div style="clear: both;"></div>  	@if($setting['inline'] =='true') @include('mmb.module.utility.inlinegrid') @endif
<script>
$(document).ready(function() {
	$('.tips').tooltip();
	$('input[type="checkbox"],input[type="radio"]').iCheck({
		checkboxClass: 'icheckbox_square-red',
		radioClass: 'iradio_square-red',
	});
	$('#{{ $pageModule }}Table .checkall').on('ifChecked',function(){
		$('#{{ $pageModule }}Table input[type="checkbox"]').iCheck('check');
	});
	$('#{{ $pageModule }}Table .checkall').on('ifUnchecked',function(){
		$('#{{ $pageModule }}Table input[type="checkbox"]').iCheck('uncheck');
	});

	$('#{{ $pageModule }}Paginate .pagination li a').click(function() {
		var url = $(this).attr('href');
		reloadData('#{{ $pageModule }}',url);
		return false ;
	});

	<?php if($setting['view-method'] =='expand') :
			echo \App\Library\AjaxHelpers::htmlExpandGrid();
		endif;
	 ?>
});
</script>
<style>
.table th { text-align: none !important;  }
.table th.right { text-align:right !important;}
.table th.center { text-align:center !important;}

</style>
