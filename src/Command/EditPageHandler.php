<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */

namespace Ithauaz\Pages\Command;

use Ithauaz\Pages\PageRepository;
use Ithauaz\Pages\PageValidator;
use Illuminate\Support\Arr;

class EditPageHandler
{
    /**
     * @var PageRepository
     */
    protected $pages;

    /**
     * @var PageValidator
     */
    protected $validator;

    /**
     * @param PageRepository $pages
     * @param PageValidator  $validator
     */
    public function __construct(PageRepository $pages, PageValidator $validator)
    {
        $this->pages = $pages;
        $this->validator = $validator;
    }

    /**
     * @param EditPage $command
     *
     * @throws \Flarum\Core\Exception\PermissionDeniedException
     *
     * @return \FoF\Pages\Page
     */
    public function handle(EditPage $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $page = $this->pages->findOrFail($command->pageId, $actor);

        $actor->assertAdmin();

        $attributes = Arr::get($data, 'attributes', []);

        if (isset($attributes['title'])) {
            $page->title = $attributes['title'];
        }

        if (isset($attributes['slug'])) {
            $page->slug = $attributes['slug'];
        }

        if (isset($attributes['content'])) {
            $page->content = $attributes['content'];
        }

        if (isset($attributes['isHidden'])) {
            $page->is_hidden = (bool) $attributes['isHidden'];
        }

        if (isset($attributes['isRestricted'])) {
            $page->is_restricted = (bool) $attributes['isRestricted'];
        }

        if (isset($attributes['isHtml'])) {
            $page->is_html = (bool) $attributes['isHtml'];
        }

        $page->edit_time = time();

        $this->validator->assertValid($page->getDirty());

        $page->save();

        return $page;
    }
}
