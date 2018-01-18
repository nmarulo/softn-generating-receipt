#if(isset($messagesModal) && is_array($messagesModal))
    <div id="messages">
    #foreach($messagesModal as $messageModal)
        <div class="modal-dialog messages-content">
            <div class="message-alert alert alert-{{$messageModal['type']}} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span>&times;</span>
                </button>
                {{$messageModal['value']}}
            </div>
        </div>
    #endforeach
    </div>
#endif
