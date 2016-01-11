package com.zhanglubao.lol.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.display.RoundedBitmapDisplayer;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.VideoGridActivity_;
import com.zhanglubao.lol.model.SimpleHeroModel;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.util.NetworkUtils;

import java.util.List;

/**
 * Created by rocks on 15-5-30.
 */
public class SimpleHeroAdapter extends BaseAdapter {
    List<SimpleHeroModel> heros;
    Context context;


    private DisplayImageOptions options;
    private LayoutInflater inflater;
    public SimpleHeroAdapter(Context context, List<SimpleHeroModel> heros) {
        this.context = context;
        this.heros = heros;
        inflater = LayoutInflater.from(context);
        options = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.default_user_avatar)
                .showImageForEmptyUri(R.drawable.default_user_avatar)
                .showImageOnFail(R.drawable.default_user_avatar)
                .displayer(new RoundedBitmapDisplayer(6))
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .considerExifParams(true)
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();
    }

    @Override
    public int getCount() {
        return heros.size();
    }

    @Override
    public Object getItem(int position) {
        return heros.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        SimpleHeroModel hero = heros.get(position);
        final ViewHolder holder;
        View view = convertView;
        if (view == null) {
            view = inflater.inflate(R.layout.item_hero_simple_grid, null);
            holder = new ViewHolder();
            holder.avatarView = (ImageView) view.findViewById(R.id.heroAvatar);
            holder.heroNameTextView = (TextView) view.findViewById(R.id.heroName);
            view.setTag(holder);
        } else {
            holder = (ViewHolder) view.getTag();
        }

        ImageLoader.getInstance().displayImage(hero.getAvatar(),
                holder.avatarView, options);
        holder.heroNameTextView.setText(hero.getName());
        view.setOnClickListener(new ItemClickListener(hero));
        return view;
    }

    static class ViewHolder {
        ImageView avatarView;
        TextView heroNameTextView;
    }


    class ItemClickListener implements View.OnClickListener {
       SimpleHeroModel heroModel;

        public ItemClickListener( SimpleHeroModel heroModel) {
            this.heroModel = heroModel;
        }

        @Override
        public void onClick(View v) {
            if (NetworkUtils.isNetworkAvailable()) {
                String url = QTUrl.video_hero_list + heroModel.getId();
                Intent intent = new Intent(context, VideoGridActivity_.class);
                intent.putExtra("title", heroModel.getNick());
                intent.putExtra("url", url);
                context.startActivity(intent);
            }
        }
    }
}
