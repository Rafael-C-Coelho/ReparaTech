package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoryDetail;

public class RepairCategoryDetailAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<RepairCategoryDetail> repairCategoryDetail;

    public RepairCategoryDetailAdapter(Context context, ArrayList<RepairCategoryDetail> repairCategoryDetail) {
        this.context = context;
        this.repairCategoryDetail = repairCategoryDetail;
    }

    @Override
    public int getCount() {
       return repairCategoryDetail.size();
    }

    @Override
    public Object getItem(int i) {
        return repairCategoryDetail.get(i);
    }

    @Override
    public long getItemId(int i) {
        return repairCategoryDetail.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        ViewHolderList viewHolderList;
        if (view == null){
            if(inflater == null){
                inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            }

            view = inflater.inflate(R.layout.fragment_repair_category, viewGroup, false);
            viewHolderList = new ViewHolderList(view);
            view.setTag(viewHolderList);
        }else{
            viewHolderList = (ViewHolderList) view.getTag();
        }
        RepairCategoryDetail repairCategoryDetail = (RepairCategoryDetail) getItem(i);
        viewHolderList.update(repairCategoryDetail);

        return view;
    }

    private class ViewHolderList{
        private TextView tvMobileDescription, tvTabletDescription,tvDesktopLaptopDescription, tvWearablesDescription;

        public ViewHolderList(View view){
            tvMobileDescription = view.findViewById(R.id.tvMobileDescription);
            tvTabletDescription = view.findViewById(R.id.tvTabletDescription);
            tvDesktopLaptopDescription = view.findViewById(R.id.tvDesktopLaptopDescription);
            tvWearablesDescription = view.findViewById(R.id.tvWearablesDescription);
        }

        public void update(RepairCategoryDetail repairCategoryDetail){
            tvMobileDescription.setText(repairCategoryDetail.getMobile_solution());
            tvTabletDescription.setText(repairCategoryDetail.getTablet_solution());
            tvDesktopLaptopDescription.setText(repairCategoryDetail.getDesktop_laptop_solution());
            tvWearablesDescription.setText(repairCategoryDetail.getWearable_solution());
        }

    }
}
