package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters_homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

import java.util.ArrayList;

public class RepairCategoryDetailAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater layoutInflater;
    private ArrayList<RepairCategoryDetailAdapter> repairCategoryDetails;

    public RepairCategoryDetailAdapter(Context context, ArrayList<RepairCategoryDetailAdapter> repairCategoryDetails) {
        this.context = context;
        this.repairCategoryDetails = repairCategoryDetails;
    }

    @Override
    public int getCount() {
        return 0;
    }

    @Override
    public Object getItem(int i) {
        return null;
    }

    @Override
    public long getItemId(int i) {
        return 0;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        return null;
    }

}
