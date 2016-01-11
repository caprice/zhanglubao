package com.zhanglubao.lol.activity;

import android.support.v4.view.ViewPager;

import com.zhanglubao.lol.R;

import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.ViewById;

/**
 * Created by rocks on 15-7-15.
 */

@EActivity(R.layout.activity_guide)
public class GuideActivity extends  BaseFragmentActivity {


    @ViewById(R.id.pager)
    ViewPager viewPager;


}
