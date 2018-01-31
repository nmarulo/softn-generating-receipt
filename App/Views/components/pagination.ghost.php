#if($component_pagination->isRendered())
<div class="pagination-container">
    <nav>
        <ul class="pagination clearfix">
            <li>
                <a class="{{$component_pagination->getLeftArrow()->getStyleClass()}}" href="#">
                    <span>{{html_entity_decode($component_pagination->getLeftArrow()->getValue())}}</span>
                </a>
            </li>
            #foreach($component_pagination->getPages() as $page)
            <li class="{{$page->getStyleClass()}}"><a href="#">{{$page->getValue()}}</a></li>
            #endforeach
            <li>
                <a class="{{$component_pagination->getRightArrow()->getStyleClass()}}" href="#">
                    <span>{{html_entity_decode($component_pagination->getRightArrow()->getValue())}}</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
#endif
