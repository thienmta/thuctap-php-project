@extends('layouts.app')

@section('content')



     <div class="row col-md-9 col-lg-9 col-sm-9 pull-left " style="background: white; ">
    <h1>Create new project </h1>

      <!-- Example row of columns -->
      <div class="row  col-md-12 col-lg-12 col-sm-12" >

      <form method="post" action="{{ route('projects.store') }}">
                            {{ csrf_field() }}


                            <div class="form-group">
                                <label for="project-name">Name<span class="required">*</span></label>
                                <input   placeholder="Enter name"  
                                          id="project-name"
                                          required
                                          name="name"
                                          spellcheck="false"
                                          class="form-control"
                                           />
                                  </div>

                                  @if($companies == null)
                                  <input   
                                  class="form-control"
                                  type="hidden"
                                          name="company_id"
                                          value="{{ $company_id }}"
                                           />
                                  </div>

                                  @endif

                            @if($companies != null)
                            <div class="form-group">
                                <label for="company-content">Select company</label>

                                <select name="company_id" class="form-control" >
                                    <option value=""> -none- </option>
                                @foreach($companies as $company)
                                        <option value="{{$company->id}}"> {{$company->name}} </option>
                                      @endforeach
                                </select>
                            </div>
                            @endif


                             <div class="form-group">
                                 <label for="comment-content">Start date</label>
                                 <div class='input-group date col-sm-4' id='datetimepicker_start_at' >
                                     <input type='text' name="start_at" class="form-control" value="{{ du()->date() }}"/>
                                     <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar">
                                                </span>
                                            </span>
                                 </div>

                                 <label for="comment-content">Finish date</label>
                                 <div class='input-group date col-sm-4' id='datetimepicker_finish_at'>
                                     <input type='text' name="finish_at" class="form-control" value="{{ du()->date() }}"/>
                                     <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                 </div>

                             </div>

                             <div class="form-group">
                                 <label for="company-content">Completed</label>
                                 <div class='input-group date col-sm-2'>
                                     <input type='text' name="completed" class="form-control" value="0"/>
                                     <span class="input-group-addon">
                                              <span class="glyphicon">%</span>
                                            </span>
                                 </div>
                             </div>

                            <div class="form-group">
                                <label for="project-content">Description</label>
                                <textarea placeholder="Enter description" 
                                          style="resize: vertical" 
                                          id="project-content"
                                          name="description"
                                          rows="5" spellcheck="false"
                                          class="form-control autosize-target text-left">

                                          
                                          </textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary"
                                       value="Submit"/>
                            </div>
                        </form>
   

      </div>
</div>

     <script type="application/javascript">
         $(function () {
             $('#datetimepicker_start_at').datetimepicker({
                 viewMode: 'days',
                 format: 'YYYY/MM/DD'
             });
             $('#datetimepicker_finish_at').datetimepicker({
                 viewMode: 'days',
                 format: 'YYYY/MM/DD'
             });
         });
     </script>


<div class="col-sm-3 col-md-3 col-lg-3 pull-right">
  <div class="sidebar-module">
    <h4>Actions</h4>
    <ol class="list-unstyled">
      <li><a href="/projects"><i class="fa fa-user-o" aria-hidden="true"></i> My projects</a></li>
    </ol>
  </div>

</div>


    @endsection