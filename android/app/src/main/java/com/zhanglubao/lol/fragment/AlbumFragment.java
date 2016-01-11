package com.zhanglubao.lol.fragment;


import com.zhanglubao.lol.R;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EFragment;

import de.greenrobot.event.EventBus;

/**
 * Created by rocks on 15-5-31.
 */
@EFragment(R.layout.fragment_album_grid)
public class AlbumFragment extends BaseFragment {

    String url;

    public static AlbumFragment newInstance(String url) {
        AlbumFragment fragment = new AlbumFragment_();
        fragment.url = url;
        return fragment;
    }
    @AfterViews
    public void afterViews() {
        mPageName=AlbumFragment.class.getName();
        if (!EventBus.getDefault().isRegistered(this)) {
            EventBus.getDefault().register(this);
        }


    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        EventBus.getDefault().unregister(this);
    }

}
