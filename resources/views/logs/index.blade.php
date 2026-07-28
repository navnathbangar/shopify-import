<x-app-layout>
   <x-slot name="header">
      <h2>Import Logs</h2>
   </x-slot>
   <div class="container-fluid mt-4">
      <div class="card shadow">
         <div class="card-header bg-dark text-white">
            <h4>Application Logs</h4>
         </div>
         <div class="card-body">
            <table class="table table-bordered table-hover">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Date</th>
                     <th>Upload ID</th>
                     <th>Product ID</th>
                     <th>Type</th>
                     <th>Message</th>
                  </tr>
               </thead>
               <tbody> 
                    @foreach($logs as $log) 
                        <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $log->upload_id }}</td>
                        <td>{{ $log->product_id }}</td>
                        <td> 
                            @if($log->type=='info') 
                            <span class="badge bg-success"> Info </span> 
                            @elseif($log->type=='warning') 
                            <span class="badge bg-warning"> Warning </span> 
                            @else <span class="badge bg-danger"> Error </span> 
                            @endif 
                        </td>
                        <td>{{ $log->message }}</td>
                        </tr> 
                    @endforeach 
                </tbody>
            </table>
            <div class="mt-3">
               {{ $logs->links() }}
            </div>
         </div>
      </div>
   </div>
</x-app-layout>