package com.zhanglubao.lol.fragment;

import android.support.v4.app.Fragment;

import com.nostra13.universalimageloader.core.ImageLoader;
import com.umeng.analytics.MobclickAgent;

/**
 * Created by rocks on 14-11-24.
 */
public class BaseFragment extends Fragment{
    protected boolean pauseOnScroll = false;
    protected boolean pauseOnFling = true;
    protected String mPageName;
    @Override
    public void onDestroy() {
        ImageLoader.getInstance().stop();
        super.onDestroy();
    }
    @Override
    public void onPause() {
        super.onPause();
        MobclickAgent.onPageEnd(mPageName);
    }

    @Override
    public void onResume() {
        super.onResume();
        MobclickAgent.onPageStart(mPageName);
    }
}
