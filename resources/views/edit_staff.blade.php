
<form action="{{ url('/update/'.$id)}}" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"  enctype="multipart/form-data">
    @csrf
  @foreach ($schema as $data => $dt )
  <table>
  <tr>  <div class="mb-4">
        <th class="block text-gray-700 text-sm font-bold mb-2" >{{$data}}</th>
        </div>
    </tr>
    <tr>
        @if ( $dt == 'varchar')

            <td>
                <input type="text"  class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="{{$data}}">
            </td>
        @elseif ($dt == 'integer' )
            <td>
                <input type="number"  class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="{{$data}}">
            </td>
       
        @elseif ($dt == 'file' )
        <td>

            <input type="file"  class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="{{$data}}">
        </td>
       
       
        @endif
  
    </tr>
  </table>
 @endforeach
 <button  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit"> Submit</button>

  </form>