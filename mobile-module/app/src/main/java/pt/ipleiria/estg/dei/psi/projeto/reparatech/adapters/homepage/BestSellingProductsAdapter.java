package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;

public class BestSellingProductsAdapter extends BaseAdapter {

    private Context context;
    private ArrayList<BestSellingProduct> bestSellingProducts;

    public BestSellingProductsAdapter(Context context, ArrayList<BestSellingProduct> bestSellingProducts) {
        this.context = context;
        this.bestSellingProducts = bestSellingProducts;
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

        ViewHolderList viewHolderList = (ViewHolderList)view.getTag();
        if (viewHolderList == null){
            viewHolderList = new ViewHolderList(view);
            view.setTag(viewHolderList);
        }

        viewHolderList.update(bestSellingProducts.get(i));
        return view;
    }

    public class ViewHolderList{

        private TextView tvBestSellingProduct, tvBestSellingProductPrice;
        private ImageView imgBestSellingProduct;

        private ViewHolderList(View view){
            tvBestSellingProduct = view.findViewById(R.id.tvBestSellingProductName);
            tvBestSellingProductPrice = view.findViewById(R.id.tvBestSellingProductPrice);
            imgBestSellingProduct = view.findViewById(R.id.imgBestSellingProduct);
        }


        public void update(BestSellingProduct bestSellingProduct) {
            tvBestSellingProduct.setText(bestSellingProduct.getTitle());
            tvBestSellingProductPrice.setText("" + bestSellingProduct.getPrice());
            imgBestSellingProduct.setImageResource(bestSellingProduct.getImg());
        }
    }
}
