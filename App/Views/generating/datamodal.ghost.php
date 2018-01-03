<div class="list-group">
    #foreach($objects as $object)
    <button class="list-group-item" type="button" data-element-id="{{$object['id']}}">{{$object[$name]}}</button>
    #endforeach
</div>
