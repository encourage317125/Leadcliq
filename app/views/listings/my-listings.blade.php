@extends('layouts.bootstrap')

@section('content')

@if (isset($message))
<p class="alert alert-success">$message</p>
@endif

<div class="page-header">
<h1>Created Leads</h1>
</div>

<div style="margin-bottom: 40px;">

	<table id="myTable" class="table table-bordered table-striped">{{-- add classes "tablesorter tablepaginator" to re-implement pagenator--}}
		<thead>
			<tr>
				
				<th>Title</th>
                <th>Type</th>
				<th>City</th>
				<th>State</th>
				<th>Company</th>
				<th>Status</th>
                <th>Action</th>
			</tr>
		</thead>
		<tbody>
            
			@foreach ($listings as $listing)
                
               <tr>
                 
			    <td><a href="/listings/{{$listing->id}}/edit">{{{ $listing->listing_title }}}</a></td>
			    <td>{{{ $listing->listing_type }}}</td>
			    <td>{{{ $listing->city?$listing->city->name:"" }}}</td>
			    <td>{{{ $listing->city?$listing->city->state:"" }}}</td>
			    <td>{{{ $listing->company?$listing->company->name:"" }}}</td>
                <td>{{{ $listing->is_published!=1 ? 'Draft' : 'Published' }}}</td>
                <td>
                      @if($listing->is_published != 1)           {{-- Show edit button for draft --}}
                            <a href="/listings/{{$listing->id}}/edit" class="btn-xs btn-default">Edit</a>
                      @else
                            <a href="/listings/{{$listing->id}}" class="btn-xs btn-default">View</a>
                      @endif
                </td>
			  </tr> 
			@endforeach

		</tbody>
	</table>
	
</div>

       <div class="row">
                <div class="col-md-12 strong-border">
                    Have more than one contact to upload?
                    <span><button class="btn btn-default" onclick="javascript:openModal();">Upload List</button></span>
                </div>
            </div>
    @include('listings.modal.select-file-upload')
 

@stop
@section('scripts')    
    <script src="/assets/js/modules/listing.js"></script>    
@stop   
