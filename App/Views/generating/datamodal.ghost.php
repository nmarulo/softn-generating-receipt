<div class="list-group">
    #foreach($objects as $object)
    <button class="list-group-item" type="button" data-element-id="{{$object['id']}}">
        <span class="item-value">{{$object['value']}}</span>
        #if(is_array($object['badge']))
            #foreach($object['badge'] as $badge)
            <span class="badge">{{$badge}}</span>
            #endforeach
        #else
        <span class="badge">{{$object['badge']}}</span>
        #endif
    </button>
    #endforeach
</div>
