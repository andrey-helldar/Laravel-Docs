@foreach($directories as $item)
@if( $item == $version )
<li class="active"><a href="#">{{ $item }}</a></li>
@else
<li><a href="{{ route('docs', ['version'=>$item]) }}">{{ $item }}</a></li>
@endif
@endforeach