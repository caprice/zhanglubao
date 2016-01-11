package com.zhanglubao.lol.fragment;

import android.support.v4.app.Fragment;

import com.zhanglubao.lol.R;

import org.androidannotations.annotations.EFragment;

/**
 * Created by rocks on 15/7/16.
 */

@EFragment(R.layout.fragment_guide)
public class GuideFragment extends Fragment {

    boolean ending = false;

    public static GuideFragment newInstance(boolean ending) {
        GuideFragment fragment = new GuideFragment_();
        fragment.ending = ending;
        return fragment;
    }

}
