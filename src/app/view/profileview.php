<?php

namespace app\view;

use core\constant\FileSuffix;
use core\constant\Separator;

use app\model\User;

class ProfileView extends MenuView
{
    protected function account()
    {
        $this->template->photo = $this->getProfilePhoto($this->profile);
        $this->template->link = $this->url->build('profile', $this->profile->getUsername());
        $this->template->name = $this->profile->getUsername();
        $this->template->videos = $this->url->build('video', 'user', $this->profile->getUsername());
        $this->template->photos = $this->url->build('photo', 'user', $this->profile->getUsername());
        $this->template->friends = $this->url->build('friends', 'user', $this->profile->getUsername());
        $this->template->blog = $this->url->build('blog', 'user', $this->profile->getUsername());
        $this->template->show($this->url->getActionPath());
    }

    private function getProfilePhoto(User $profile)
    {
        if ($profile->hasAvatar())
        {
            $photo = $profile->getId() . Separator::SLASH . 'profile' . FileSuffix::JPG;
            if (file_exists(PATH_PHOTOS . $photo))
            {
                return URL_PHOTOS . $photo;
            }
        }
        return URL_STATIC . 'web/images/profile-2'.FileSuffix::PNG;
    }

    /**
     * @MenuBundle = "link.header.profile.videos"
     */
    protected function videos()
    {
    }

    /**
     * @MenuBundle = "link.header.profile.friends"
     */
    protected function friends()
    {
    }

}

?>