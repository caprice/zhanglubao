package com.zhanglubao.lol.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.support.v4.view.PagerAdapter;
import android.util.SparseArray;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.VideoDetailActivity_;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.model.SlideModel;

import java.util.List;

/**
 * Created by rocks on 15-5-29.
 */
public class BannerPagerAdapter extends PagerAdapter {


    Context context;
    List<SlideModel> slides;
    private DisplayImageOptions options;
    private SparseArray<ImageView> imageViews = new SparseArray<ImageView>();

    public BannerPagerAdapter(Context context, List<SlideModel> slides) {
        this.context = context;
        this.slides = slides;

        options = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.banner_default_image)
                .showImageForEmptyUri(R.drawable.banner_default_image)
                .showImageOnFail(R.drawable.banner_default_image)
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .considerExifParams(true)
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();
    }

    @Override
    public int getCount() {
        return slides.size();
    }

    @Override
    public boolean isViewFromObject(View view, Object object) {
        return view == object;
    }

    @Override
    public Object instantiateItem(ViewGroup container, int position) {

        ImageView localImageView = imageViews.get(position);
        if (localImageView == null) {
            localImageView = new ImageView(context);
            localImageView.setLayoutParams(new ViewGroup.LayoutParams(-1, -1));
            localImageView.setScaleType(ImageView.ScaleType.CENTER_CROP);
            SlideModel slideModel = slides.get(position);
            ImageLoader.getInstance().displayImage(slideModel.getSlide_picture(),
                    localImageView, options);
            localImageView.setOnClickListener(new BannerItemClickListener(slideModel));

            imageViews.put(position, localImageView);
        }
        container.addView(localImageView);
        return localImageView;
    }

    class BannerItemClickListener implements View.OnClickListener {
        SlideModel slideModel;

        public BannerItemClickListener(SlideModel slideModel) {
            this.slideModel = slideModel;
        }

        @Override
        public void onClick(View v) {
            switch (slideModel.getType()) {
                case "1":
                    SimpleVideoModel videoModel=new SimpleVideoModel();
                    videoModel.setId(slideModel.getValue_id());
                    videoModel.setVideo_title(slideModel.getTitle());
                    videoModel.setVideo_picture(slideModel.getSlide_picture());

                    Intent intent = new Intent(context, VideoDetailActivity_.class);
                    intent.putExtra("video", videoModel);
                    context.startActivity(intent);
                    break;

            }
        }
    }


    @Override
    public void destroyItem(ViewGroup container, int position, Object object) {
        container.removeView(imageViews.get(position));
    }
}
