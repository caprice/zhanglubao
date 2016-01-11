

package com.zhanglubao.lol.view.banner;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.RectF;
import android.os.Parcelable;
import android.util.AttributeSet;
import android.util.Log;
import android.view.View;

/**
 * 圆点指示器，用圆点指示出当前广告页面的位置。如果想要其他效果的指示器可以去实现AdIndicator的子类。
 * <p>
 * 本视图默认会画出一小排间距相同的圆点。每一个广告页面对应一个圆点，广告页面的数量和圆点的数量相同。
 * 当前广告页面对应的圆点外观与其他页面不用，用不同于其他圆点的圆点来标识当前页面的位置。
 * 
 */
public class DotAdIndicator extends View implements AdIndicator {
	private static final String LOG_TAG = "DotAdIndicator";
	private static final boolean localLOG = false;

	/** 默认的圆点直径大小，单位dp */
	private static final float DEFAULT_DOT_WIDTH = 5.0f;

	/** 默认的圆点间距大小，单位dp */
	private static final float DEFAULT_GAP_WIDTH = 5.0f;

	/** 未选中圆点默认颜色 */
	private static final int DEFAULT_NORMAL_COLOR = 0xffdddddd;

	/** 选中圆点默认颜色 */
	private static final int DEFAULT_CURRENT_COLOR = 0xffff3500;

	/** 当前选中的圆点画笔 */
	private Paint mPaintCurrent = new Paint(Paint.ANTI_ALIAS_FLAG);

	/** 未选中的圆点的画笔 */
	private Paint mPaintNormal = new Paint(Paint.ANTI_ALIAS_FLAG);

	/** 圆点之间的间距大小，单位为px */
	private int mRawGapWidth;

	/** 圆点的直径大小，单位px */
	private int mRawDotWidth;

	/** 圆点指示器在视图内部的位置 */
	// private int mGravity = Gravity.CENTER;

	/** 当前显示的广告页面的索引（从0开始） */
	private int mCurrentPage;

	/** 页面的总数量 */
	private int mPageCount;

	/** 用来确定所画圆点位置的RectF对象，仅仅为了画圆点方便 */
	private RectF ovalRectF = new RectF();

	public DotAdIndicator(Context context) {
		super(context);
		init();
	}

	public DotAdIndicator(Context context, AttributeSet attrs) {
		super(context, attrs);
		init();
	}

	public DotAdIndicator(Context context, AttributeSet attrs, int defStyleAttr) {
		super(context, attrs, defStyleAttr);
		init();
	}

	/**
	 * 初始化设置画笔默认颜色与默认间距和圆点直径
	 */
	private void init() {
		mPaintCurrent.setColor(DEFAULT_CURRENT_COLOR);
		mPaintNormal.setColor(DEFAULT_NORMAL_COLOR);

		final float density = getResources().getDisplayMetrics().density;
		// 向上取整
		mRawDotWidth = (int) Math.ceil(density * DEFAULT_DOT_WIDTH);
		mRawGapWidth = (int) Math.ceil(density * DEFAULT_GAP_WIDTH);
	}

	/**
	 * 设置选中状态的圆点颜色
	 * 
	 * @param color
	 *            ARGB颜色值
	 */
	public void setSelectedColor(int color) {
		mPaintCurrent.setColor(color);
		invalidate();
	}

	/**
	 * 返回选中状态的圆点的颜色
	 * 
	 * @return ARGB颜色值
	 */
	public int getSelectedColor() {
		return mPaintCurrent.getColor();
	}

	/**
	 * 设置未选中状态的圆点颜色
	 * 
	 * @param color
	 *            ARGB颜色值
	 */
	public void setUnselectedColor(int color) {
		mPaintNormal.setColor(color);
		invalidate();
	}

	/**
	 * 返回未选中状态的圆点的颜色
	 * 
	 * @return ARGB颜色值
	 */
	public int getUnselectedColor() {
		return mPaintNormal.getColor();
	}

	/**
	 * 设置圆点之间的间距大小，单位dp
	 * 
	 * @param width
	 *            间距大小
	 */
	public void setGapWidth(float width) {
		final float density = getResources().getDisplayMetrics().density;
		mRawGapWidth = (int) Math.ceil(width * density);
		invalidate();
	}

	/**
	 * 设置圆点直径的大小，单位dp
	 * 
	 * @param width
	 *            圆点直径
	 */
	public void setDotWidth(float width) {
		final float density = getResources().getDisplayMetrics().density;
		mRawDotWidth = (int) Math.ceil(width * density);
		invalidate();
	}

	@Override
	protected void onDraw(Canvas canvas) {
		super.onDraw(canvas);

		final int count;

		if (isInEditMode()) {
			count = 7;
			mCurrentPage = 2;
		} else {
			count = mPageCount;
		}

		if (count < 2) {
			return;
		}

		final float dotWidthAndGap = mRawDotWidth + mRawGapWidth+10;
		final float indicatorWidth = (count * dotWidthAndGap) - mRawGapWidth;

		// 计算出指示器相对左上角应当偏移的位置，稍后将画布移动到偏移位置
		float translateX = (getWidth() + getPaddingLeft() - getPaddingRight() - indicatorWidth) / 2.0f;
		float translateY = (getHeight() + getPaddingTop() - getPaddingBottom() - mRawDotWidth) / 2.0f;

		canvas.save();
		canvas.translate(translateX, translateY);

		for (int i = 0; i < count; ++i) {
			float dx1 = i * dotWidthAndGap;
			float dx2 = dx1 + mRawDotWidth;
			ovalRectF.set(dx1, 0, dx2, mRawDotWidth);
			canvas.drawOval(ovalRectF, i == mCurrentPage ? mPaintCurrent
					: mPaintNormal);
		}

		canvas.restore();
	}

	@Override
	protected void onMeasure(int widthMeasureSpec, int heightMeasureSpec) {
		setMeasuredDimension(measureWidth(widthMeasureSpec),
				measureHeight(heightMeasureSpec));
	}

	/**
	 * 计算指示器View的宽度应该是多少像素
	 * 
	 * @param measureSpec
	 *            measureSpec
	 * @return View的宽度
	 */
	private int measureWidth(int measureSpec) {
		float result;
		int specMode = MeasureSpec.getMode(measureSpec);
		int specSize = MeasureSpec.getSize(measureSpec);

		if (specMode == MeasureSpec.EXACTLY) {
			result = specSize;
		} else {
			if (mPageCount > 1) {
				result = mPageCount * (mRawDotWidth + mRawGapWidth)
						- mRawGapWidth + getPaddingLeft() + getPaddingRight();
			} else {
				result = getPaddingLeft() + getPaddingRight();
			}
			if (specMode == MeasureSpec.AT_MOST) {
				result = Math.min(result, specSize);
			}
		}
		return (int) Math.ceil(result);
	}

	/**
	 * 计算指示器View的高度应该是多少像素
	 * 
	 * @param measureSpec
	 *            measureSpec
	 * @return View的高度
	 */
	private int measureHeight(int measureSpec) {
		float result;
		int specMode = MeasureSpec.getMode(measureSpec);
		int specSize = MeasureSpec.getSize(measureSpec);

		if (specMode == MeasureSpec.EXACTLY) {
			result = specSize;
		} else {
			result = mRawDotWidth + getPaddingTop() + getPaddingBottom();
			if (specMode == MeasureSpec.AT_MOST) {
				result = Math.min(result, specSize);
			}
		}
		return (int) Math.ceil(result);
	}

	@Override
	protected Parcelable onSaveInstanceState() {
		return super.onSaveInstanceState();
		// TODO 保存状态
	}

	@Override
	protected void onRestoreInstanceState(Parcelable state) {
		super.onRestoreInstanceState(state);
		// TODO 恢复状态
	}

	@Override
	public void onPageScrolled(int position, float positionOffset,
			int positionOffsetPixels) {
		if (localLOG) {
			Log.i(LOG_TAG, "position：" + position);
			Log.i(LOG_TAG, "positionOffset：" + positionOffset);
			Log.i(LOG_TAG, "positionOffsetPixels：" + positionOffsetPixels);
		}
		// TODO 如果想要选中的圆点切换时，有平移动画等效果，请考虑在这里处理。
	}

	@Override
	public void onPageSelected(int position) {
		mCurrentPage = position;
		invalidate();
	}

	@Override
	public void onPageScrollStateChanged(int state) {
		if (localLOG) {
			Log.i(LOG_TAG, "state：" + state);
		}
	}

	@Override
	public void notifyPageCountChanged(int current, int pageCount) {
		mCurrentPage = current;
		mPageCount = pageCount;
		invalidate();
	}

}
