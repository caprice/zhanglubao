package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.SniffModel;

/**
 * Created by rocks on 15-6-12.
 */
public class SniffEntity {

    SniffModel normal;
    SniffModel high;
    SniffModel hd;
    SniffModel original;

    public SniffModel getHd() {
        return hd;
    }

    public void setHd(SniffModel hd) {
        this.hd = hd;
    }

    public SniffModel getHigh() {
        return high;
    }

    public void setHigh(SniffModel high) {
        this.high = high;
    }

    public SniffModel getNormal() {
        return normal;
    }

    public void setNormal(SniffModel normal) {
        this.normal = normal;
    }

    public SniffModel getOriginal() {
        return original;
    }

    public void setOriginal(SniffModel original) {
        this.original = original;
    }
}
