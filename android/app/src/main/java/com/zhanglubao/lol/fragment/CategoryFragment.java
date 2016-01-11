package com.zhanglubao.lol.fragment;

import android.support.v4.app.Fragment;
import android.support.v4.view.ViewPager;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.TitleFragmentAdapter;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.view.widget.TabPageIndicator;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.ViewById;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Created by rocks on 14-12-6.
 */
@EFragment(R.layout.fragment_category)
public class CategoryFragment extends BaseFragment {

    @ViewById(R.id.category_indicator)
    TabPageIndicator viewPagerIndicator;
    @ViewById(R.id.category_pager)
    ViewPager viewPager;

    @AfterViews
    public void afterViews() {
        mPageName=CategoryFragment.class.getName();
        List<String> items = Arrays.asList(getActivity().getResources().getStringArray(R.array.tab_category));



        List<Fragment> fragments = new ArrayList<Fragment>();
        fragments.add(CategoryIndexFragment_.newInstance());
        fragments.add(CategoryHeroFragment_.newInstance());
        fragments.add(UserGridFragment_.newInstance(QTUrl.cate_comm_user));
        fragments.add(AlbumGridFragment_.newInstance());
        fragments.add(UserGridFragment_.newInstance(QTUrl.cate_master_user));
        fragments.add(UserGridFragment_.newInstance(QTUrl.cate_pro_user));
        fragments.add(UserGridFragment_.newInstance(QTUrl.cate_team_user));
        fragments.add(UserGridFragment_.newInstance(QTUrl.cate_match_user));





        TitleFragmentAdapter fragmentAdapter = new TitleFragmentAdapter(getChildFragmentManager(), viewPager, fragments, items);
        viewPager.setAdapter(fragmentAdapter);
        viewPagerIndicator.setViewPager(viewPager);


    }
}
