package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.SearchView;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategory;

public class RepairCategoriesListAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<RepairCategory> repairCategories;
    private SearchView searchView;

    public RepairCategoriesListAdapter(Context context, ArrayList<RepairCategory> repairCategories) {
        this.context = context;
        this.repairCategories = repairCategories;
    }

    @Override
    public int getCount() {
        return repairCategories.size();
    }

    @Override
    public Object getItem(int i) {
        return repairCategories.get(i);
    }

    @Override
    public long getItemId(int i) {
        return repairCategories.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (view == null){
            view = inflater.inflate(R.layout.item_repair_category,null);
        }

        ViewHolderList viewHolderList = (ViewHolderList) view.getTag();
        if (viewHolderList == null){
            viewHolderList = new ViewHolderList(view);
            view.setTag(viewHolderList);
        }

        viewHolderList.update(repairCategories.get(i));

        return view;
    }


    private class ViewHolderList {

        private TextView tvRepairCategoryName, tvCategoryDescription;
        private ImageView imgRepairCategoryList;

       public ViewHolderList(View view){

           tvRepairCategoryName = view.findViewById(R.id.tvRepairCategoryName);
           tvCategoryDescription = view.findViewById(R.id.tvCategoryDescription);
           imgRepairCategoryList = view.findViewById(R.id.imgRepairCategoryList);
       }

        public void update(RepairCategory repairCategory) {
           tvRepairCategoryName.setText(repairCategory.getTitle());
           tvCategoryDescription.setText(repairCategory.getDescription());
           imgRepairCategoryList.setImageResource(repairCategory.getImg());
        }
    }

}
