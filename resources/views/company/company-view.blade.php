@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Empresas
                    <!--<a class="pull-right" href="{{ url('admin/companies/create') }}">Novo</a>-->
                </div>
                <div class="panel-body">
                    @if(Session::has('message_warning'))
                        <div class="alert alert-warning alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ Session::get('message_warning') }}
                        </div>
                    @endif
                    @if(Session::has('message_danger'))
                        <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ Session::get('message_danger') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2"
                                        width="5%">&nbsp;</th>
                                    <th>Razão Social</th>
                                    <th>Nome Fantasia</th>
                                    <th>Status</th>
                                    <th>Cidade</th>
                                    <th>Usuário</th>
                                    <th>E-mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                    <tr>
                                        <td><a class="btn btn-default btn-xs" href="{{ url('admin/companies/'. $company->id.'/details')}}"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                        <td>
                                            <form style="display: inline;" 
                                                  method="POST" 
                                                  action="{{ url('admin/companies/'.$company->id.'/remove') }}">
                                                <input name="_method" type="hidden" value="DELETE">
                                                {{ csrf_field() }}
                                                <button class="btn btn-danger btn-xs" 
                                                        type="submit"
                                                        name="remove_levels"><span class="glyphicon glyphicon-trash"></span></button>
                                            </form>
                                            
                                        </td>
                                        <td>{{ ucwords($company->companyname) }}</td>
                                        <td>{{ ucwords($company->tradingname) }}</td>
                                        <td>{{ $company->getStatus() }}</td>
                                        <td>{{ isset($company->city) ? ucwords($company->city->name) : '' }}</td>
                                        <td>{{ ucwords($company->user->completeName()) }}</td>
                                        <td>{{ $company->user->email }}</td>

                                    </tr>
                                    
                                @endforeach 
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        {{ $companies->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                     
                </div>
                
            </div>
        </div>
    </div>
</div>
<div class="modal" id="confirmModal" style="display: none; z-index: 1050;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="confirmMessage">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="confirmOk">Ok</button>
                <button type="button" class="btn btn-default" id="confirmCancel">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function confirmDialog(message, onConfirm){
    var fClose = function(){
        modal.modal("hide");
    };
    var modal = $("#confirmModal");
    modal.modal("show");
    $("#confirmMessage").empty().append(message);
    $("#confirmOk").one('click', onConfirm);
    $("#confirmOk").one('click', fClose);
    $("#confirmCancel").one("click", fClose);
}


$('button[name="remove_levels"]').on('click', function(e) {
    $form = $(this).closest('form');
    e.preventDefault();
    confirmDialog('Confirma a exclusão ?', function() {
      $form.trigger('submit');  
    });
});
</script>

@endsection
