@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
  <form action="{{route('rolesstore')}}" method="post">
    @csrf
    <input type="hidden" name="r_status" value="1">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Role Name')}}</label>
                <input type="text" name="r_name" value="{{ old('r_name') }}" required="required" class="form-control" >        
            </div>
        </div>  
        <div class="col-md-6"></div>    
    </div>        
    

<div class="gcsppermissionwapper">    
    <div class="permissionLicensestable mt-3">
        <h4>{{__('Assign Licenses')}}</h4>
        <table class="table tablefirst mt-3" >
            <thead class="thead-light">
                <tr>
                    <th scope="col" width="55%">{{__('Module Name')}}</th>
                    <th scope="col" width="15%" class="text-center">{{__('Add')}}</th>
                    <th scope="col" width="15%" class="text-center">{{__('Edit')}}</th>
                    <th scope="col" width="15%" class="text-center">{{__('Delete')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><input value="57" type="checkbox" class="gcspparent57" id="NearMiss" name="upd_pm_id[]"><label for="NearMiss">{{__('Near Miss')}}</label> </th>
                    <td><input value="58" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="59" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="60" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <td scope="row">
                        <table class="table Licensestableinner">
                            <tr>
                                <td><input class="gcsppermitcheck57" data-parent="57" value="61" id="Close61" type="checkbox" name="upd_pm_id[]"><label for="Close61">{{__('Close')}}</label></td>                                
                                <td><input class="gcsppermitcheck57" data-parent="57" value="64" id="Close64" type="checkbox" name="upd_pm_id[]"><label for="Close64">{{__('Risk Potential Level')}}</label></td>                                
                            </tr>
                        </table>
                    </td>
                    <td colspan="3"></td>                    
                </tr>
                <tr>
                    <th scope="row"><input value="53" type="checkbox" class="gcspparent53" id="Actions" name="upd_pm_id[]"><label for="Actions">{{__('Actions')}}</label> </th>
                    <td><input value="54" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="55" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="56" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="1" class="gcspparent1" type="checkbox" id="Audit" name="upd_pm_id[]"><label for="Audit">{{__('Audit')}}</label> </th>
                    <td><input value="2" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="3" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="4" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="5" class="gcspparent5"  type="checkbox" id="Incident" name="upd_pm_id[]"><label for="Incident">{{__('Incident')}}</label> </th>
                    <td><input value="6" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="7" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="8" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <td scope="row">
                        <table class="table Licensestableinner">
                            <tr>
                                <td><input class="gcsppermitcheck5"  data-parent="5" value="62" id="Close62" type="checkbox" name="upd_pm_id[]"><label for="Close62">{{__('Close')}}</label></td>                                
                                <td><input class="gcsppermitcheck5"  data-parent="5" value="63" id="Reject63" type="checkbox" name="upd_pm_id[]"><label for="Reject63">{{__('Approve')}}/{{__('Reject')}}</label></td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="3"></td>                    
                </tr>
                <tr>
                    <th scope="row"><input value="9" type="checkbox" id="Permit" name="upd_pm_id[]" class="gcsppermitcheck gcspparent9"><label for="Permit">{{__('Permit')}}</label></th>
                    <td><input value="10" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="11" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="12" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <td scope="row">
                        <table class="table Licensestableinner">
                            <tr>
                                <td ><input class="gcsppermitcheck9" data-parent="9" value="13" id="Revoke" type="checkbox"  name="upd_pm_id[]"><label for="Revoke">{{__('Revoke')}}</label></td>
                                <td ><input class="gcsppermitcheck9" data-parent="9"  value="14" id="Extend" type="checkbox" name="upd_pm_id[]"><label for="Extend">{{__('Extend')}}</label></td>
                                <td ><input class="gcsppermitcheck9" data-parent="9"  value="15" id="Close" type="checkbox" name="upd_pm_id[]"><label for="Close">{{__('Close')}}</label></td>
                                <td ><input class="gcsppermitcheck9" data-parent="9"  value="16" id="Reject" type="checkbox" name="upd_pm_id[]"><label for="Reject">{{__('Reject')}}</label></td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="3"></td>                    
                </tr>
            </tbody>
        </table>
    </div>

    <div class="permissionLicensestable mt-5 mb-5 ">
        <h4>{{__('Grant Admin Access Privileges')}}</h4>
        <table class="table tablefirst tablesecond mt-3" >
            <thead class="thead-light">
                <tr>
                    <th scope="col" width="55%">{{__('Section Name')}}</th>
                    <th scope="col" width="15%" class="text-center">{{__('Add')}}</th>
                    <th scope="col" width="15%" class="text-center">{{__('Edit')}}</th>
                    <th scope="col" width="15%" class="text-center">{{__('Delete')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><input value="17" type="checkbox" id="AuditTemplate" name="upd_pm_id[]"><label for="AuditTemplate">{{__('Audit Template')}}</label> </th>
                    <td><input value="18" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="19" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="20" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="21" type="checkbox" id="Categories" name="upd_pm_id[]"><label for="Categories">{{__('Categories')}}</label> </th>
                    <td><input value="22" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="23" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="24" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="25" type="checkbox" id="HIRA" name="upd_pm_id[]"><label for="HIRA">{{__('HIRA')}}</label> </th>
                    <td><input value="26" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="27" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="28" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="29" type="checkbox" id="PermitTemplates" name="upd_pm_id[]"><label for="PermitTemplates">{{__('Permit Templates')}}</label> </th>
                    <td><input value="30" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="31" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="32" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="33" type="checkbox" id="RootCause" name="upd_pm_id[]"><label for="RootCause">{{__('Root Cause')}}</label> </th>
                    <td><input value="34" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="35" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="36" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="37" type="checkbox" id="Roles" name="upd_pm_id[]"><label for="Roles">{{__('Roles')}}</label> </th>
                    <td><input value="38" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="39" type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="40" type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="41" type="checkbox" id="Sites" name="upd_pm_id[]"><label for="Sites">{{__('Sites')}}</label> </th>
                    <td><input value="42"  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="43"  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="44"  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="45"  type="checkbox" id="User" name="upd_pm_id[]"><label for="User">{{__('Users')}}</label> </th>
                    <td><input value="45"  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="47"  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="48"  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="49"    type="checkbox" id="Workflows" name="upd_pm_id[]"><label for="Workflows">{{__('Workflows')}}</label></th>
                    <td><input value="50"   type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="51"   type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="52"   type="checkbox" name="upd_pm_id[]"></td>
                </tr>                
            </tbody>
        </table>
    </div>
</div>

    
    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button> 
</form>
</div>
@endsection
