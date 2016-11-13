@if(isset($menuNodes) && count($menuNodes) > 0)
    <ol class="dd-list">
        @foreach($menuNodes as $key => $row)
            <?php
            $item = $row['value'];
            $dataTitle = $item->title;
            if (!$dataTitle || $dataTitle == '' || trim($dataTitle, '') == '') {
                switch ($item->type) {
                    case 'category': {
                        $category = $item->category;
                        if ($category) {
                            $dataTitle = $category->global_title;
                        }
                    }
                        break;
                    case 'product-category': {
                        $category = $item->productCategory;
                        if ($category) {
                            $dataTitle = $category->global_title;
                        }
                    }
                        break;
                    case 'page': {
                        $post = $item->page;
                        if ($post) {
                            $dataTitle = $post->global_title;
                        }
                    }
                        break;
                    default: {
                        $post = $item->page;
                        if ($post) {
                            $dataTitle = $post->global_title;
                        }
                    }
                        break;
                }
            }
            $dataTitle = htmlentities($dataTitle);
            ?>
            <li class="dd-item dd3-item {{ (($item->related_id > 0 && $item->related_id != '' && $item->related_id != NULL) ? 'post-item' : '') }}"
                data-type="{{ $item->type or '' }}"
                data-relatedid="{{ $item->related_id or '' }}"
                data-title="{{ $item->title or '' }}"
                data-css_class="{{ $item->css_class or '' }}"
                data-id="{{ $item->id or '' }}"
                data-url="{{ $item->url or '' }}"
                data-icon_font="{{ $item->icon_font or '' }}">
                <div class="dd-handle dd3-handle"></div>
                <div class="dd3-content">
                    <span class="text pull-left"
                          data-update="title">{{ $dataTitle }}</span>
                    <span class="text pull-right">{{ $item->type or '' }}</span>
                    <a href="#" title="" class="show-item-details">
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div class="item-details">
                    <label class="pad-bot-5">
                        <span class="text pad-top-5 dis-inline-block"
                              data-update="title">Title</span>
                        <input type="text" name="title"
                               value="{{ $item->title or '' }}" data-old="">
                    </label>
                    <label class="pad-bot-5 dis-inline-block">
                        <span class="text pad-top-5"
                              data-update="url">Url</span>
                        <input type="text" name="url"
                               value="{{ $item->url or '' }}" data-old="">
                    </label>
                    <label class="pad-bot-5 dis-inline-block">
                        <span class="text pad-top-5" data-update="icon_font">Icon - font</span>
                        <input type="text" name="icon_font"
                               value="{{ $item->icon_font or '' }}" data-old="">
                    </label>
                    <label class="pad-bot-10">
                        <span class="text pad-top-5 dis-inline-block">CSS class</span>
                        <input type="text" name="css_class"
                               value="{{ $item->css_class or '' }}" data-old="">
                    </label>
                    <div class="text-right">
                        <a href="#" title="" class="btn red btn-remove btn-sm">Remove</a>
                        <a href="#" title="" class="btn blue btn-cancel btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="clearfix"></div>
                @if(isset($row['child']))
                    @include('admin._partials.menu._nestable-menu-src', ['menuNodes' => $row['child']])
                @endif
            </li>
        @endforeach
    </ol>
@endif