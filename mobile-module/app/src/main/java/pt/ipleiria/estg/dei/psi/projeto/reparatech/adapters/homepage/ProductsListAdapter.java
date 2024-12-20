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
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;

public class ProductsListAdapter extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Product> products;

    public ProductsListAdapter(Context context, ArrayList<Product> products) {
        this.context = context;
        this.products = products;
    }

    @Override
    public int getCount() {
        return products.size();
    }

    @Override
    public Object getItem(int position) {
        return products.get(position);
    }

    @Override
    public long getItemId(int position) {
        return products.get(position).getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        if(inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if(convertView == null){
            convertView = inflater.inflate(R.layout.item_list_product_test, null);
        }

        ViewHolderList viewHolderList = (ViewHolderList) convertView.getTag();
        if(viewHolderList == null){
            viewHolderList = new ViewHolderList(convertView);
            convertView.setTag(viewHolderList);
        }

        viewHolderList.update(products.get(position));

        return convertView;
    }

    private class ViewHolderList {

        private TextView tvNameProduct,tvDescriptionProduct, tvPriceProduct;
        private ImageView imgProduct;
        public ViewHolderList(View view) {
            tvNameProduct = view.findViewById(R.id.tvNameDetailsProduct);
            tvPriceProduct = view.findViewById(R.id.tvPriceDetailsProduct);
            imgProduct = view.findViewById(R.id.imgDetailsProduct);
        }

        public void update(Product product) {
            tvNameProduct.setText(product.getName());
            tvPriceProduct.setText(product.getPrice()+"€");
            imgProduct.setImageResource(product.getImage());
        }
    }
}
