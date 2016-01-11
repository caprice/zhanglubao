package com.zhanglubao.lol.fragment;

import android.support.v4.app.Fragment;
import android.support.v4.view.ViewPager;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.FragmentAdapter;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.view.widget.ViewPagerIndicator;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.ViewById;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Created by rocks on 14-11-24.
 */
@EFragment(R.layout.fragment_top)
public class TopFragment extends  BaseFragment{

    @ViewById(R.id.top_indicator)
    ViewPagerIndicator viewPagerIndicator;
    @ViewById(R.id.top_pager)
    ViewPager viewPager;

    @AfterViews
    public void afterViews() {
        mPageName=TopFragment.class.getName();
        List<String> items = Arrays.asList(getActivity().getResources().getStringArray(R.array.tab_hot));

        viewPagerIndicator.initSubView(items);

        List<Fragment> fragments = new ArrayList<Fragment>();
        fragments.add(VideoGridFragment_.newInstance(QTUrl.top_day_video));
        fragments.add(VideoGridFragment_.newInstance(QTUrl.top_week_video));
        fragments.add(VideoGridFragment_.newInstance(QTUrl.top_month_video));
        fragments.add(VideoGridFragment_.newInstance(QTUrl.top_all_video));

        FragmentAdapter fragmentAdapter=new FragmentAdapter(getChildFragmentManager(),viewPager,fragments);
        viewPager.setAdapter(fragmentAdapter);
        viewPagerIndicator.setViewPager(viewPager);


    }

}
