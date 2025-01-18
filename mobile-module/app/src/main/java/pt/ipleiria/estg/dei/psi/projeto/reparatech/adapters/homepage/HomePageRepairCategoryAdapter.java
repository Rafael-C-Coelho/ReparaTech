package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.HomePageRepairCategory;


public class HomePageRepairCategoryAdapter extends BaseAdapter {

    private ArrayList<HomePageRepairCategory> homePageRepairCategories;
    private Context context;
    private LayoutInflater inflater;

    public HomePageRepairCategoryAdapter(Context context, ArrayList<HomePageRepairCategory> homePageRepairCategories) {
        this.context = context;
        this.homePageRepairCategories = homePageRepairCategories;
    }

    @Override
    public int getCount() {
        return homePageRepairCategories.size();
    }

    @Override
    public Object getItem(int i) {
        return homePageRepairCategories.get(i);
    }

    @Override
    public long getItemId(int i) {
        return homePageRepairCategories.get(i).getId();
    }

    @Override
    public View getView(int i,View convertView, ViewGroup viewGroup) {
        if (inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (convertView == null){
            convertView = inflater.inflate(R.layout.item_repair_category_homepage_example, null);
        }

        ViewHolderList viewHolderList = (ViewHolderList) convertView.getTag();
        if(viewHolderList == null){
            viewHolderList = new ViewHolderList(convertView);
            convertView.setTag(viewHolderList);
        }

        viewHolderList.update(homePageRepairCategories.get(i));

        return convertView;
    }

    private class ViewHolderList{
        private TextView tvRepairCategoryNameHomepage;
        private ImageView imgRepairCategoryHomepage;

        public ViewHolderList(View view) {
            tvRepairCategoryNameHomepage = view.findViewById(R.id.tvRepairCategoryNameHomepage);
            imgRepairCategoryHomepage = view.findViewById(R.id.imgRepairCategoryHomepage);
        }

        public void update(HomePageRepairCategory homePageRepairCategory){
            tvRepairCategoryNameHomepage.setText(homePageRepairCategory.getRepairCategoryName());
            imgRepairCategoryHomepage.setImageResource(homePageRepairCategory.getRepairCategoryImage());
        }

    }
}
