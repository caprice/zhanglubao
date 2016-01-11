package com.zhanglubao.lol.fragment;

import android.view.View;
import android.widget.GridView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.SimpleHeroAdapter;
import com.zhanglubao.lol.model.SimpleHeroModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.network.entity.SimpleHeroListEntity;
import com.zhanglubao.pulltorefresh.PullToRefreshBase;
import com.zhanglubao.pulltorefresh.PullToRefreshGridView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.UiThread;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rocks on 14-12-6.
 */
@EFragment(R.layout.fragment_hero_gird)
public class CategoryHeroFragment extends BaseFragment {
    public static CategoryHeroFragment newInstance() {
        CategoryHeroFragment fragment = new CategoryHeroFragment_();
        return fragment;
    }
    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;


    @ViewById(R.id.heroGird)
    PullToRefreshGridView heroGird;
    int page = 0;
    boolean isPull = false;

    List<SimpleHeroModel> heros;
    SimpleHeroAdapter heroAdapter;

   

    @AfterViews
    public void afterViews() {
        mPageName=CategoryHeroFragment.class.getName();
        heros = new ArrayList<SimpleHeroModel>();
        heroGird.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<GridView>() {
            @Override
            public void onPullDownToRefresh(PullToRefreshBase<GridView> refreshView) {
                page = 0;
                isPull = true;
                getData(page);
            }

            @Override
            public void onPullUpToRefresh(PullToRefreshBase<GridView> refreshView) {
                isPull = true;
                page++;
                getData(page);
            }
        });
        heroAdapter = new SimpleHeroAdapter(getActivity(), heros);
        heroGird.setAdapter(heroAdapter);
        getData(page);
    }

    public void getData(int page) {
        if (!isPull) {
            loadingBar.setVisibility(View.VISIBLE);
        }
        QTApi.getUrlPage(QTUrl.cate_hero_hero, page, new TextHttpResponseHandler() {


            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                try {
                    SimpleHeroListEntity simpleHeroListEntity = (SimpleHeroListEntity) JSON.parseObject(response, SimpleHeroListEntity.class);
                    recevieData(simpleHeroListEntity.getHeros());

                } catch (Exception e) {

                    receiveError();
                }
            }

            @Override
            public void onFailure(int i, Header[] headers, String response, Throwable throwable) {
                receiveError();
            }
        });
    }

    public void receiveError() {
        netWorkErrorView.setVisibility(View.VISIBLE);
        heroGird.onRefreshComplete();
    }

    @UiThread
    public void recevieData(List<SimpleHeroModel> heroModels) {
        if (heroModels==null)
        {

            heroGird.onRefreshComplete();
            return;
        }
        loadingBar.setVisibility(View.GONE);
        heroGird.onRefreshComplete();
        if (page == 0) {
            heros.clear();
        }
        heros.addAll(heroModels);
        heroAdapter.notifyDataSetChanged();
        heroGird.requestLayout();
    }



}
