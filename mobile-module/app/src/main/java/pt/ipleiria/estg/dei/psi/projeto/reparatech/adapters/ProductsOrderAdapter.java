package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.SaleProduct;

public class ProductsOrderAdapter extends BaseAdapter {
    private final Context context;
    private final ArrayList<SaleProduct> products;
    private final LayoutInflater inflater;

    public ProductsOrderAdapter(Context context, ArrayList<SaleProduct> products) {
        this.context = context;
        this.products = products;
        this.inflater = LayoutInflater.from(context);
    }

    @Override
    public int getCount() {
        return products.size();
    }

    @Override
    public SaleProduct getItem(int position) {
        return products.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        ViewHolder holder;

        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_product_order, null);
        }

        ViewHolder viewHolderList = (ViewHolder) convertView.getTag();
        if (viewHolderList == null) {
            viewHolderList = new ViewHolder(convertView);
            convertView.setTag(viewHolderList);
        }
        viewHolderList.update(products.get(position));

        return convertView;
    }

    private static class ViewHolder {
        TextView productIdText;
        TextView quantityText;
        TextView totalPriceText;

        public ViewHolder(View view) {
            productIdText = view.findViewById(R.id.productIdText);
            quantityText = view.findViewById(R.id.quantityText);
            totalPriceText = view.findViewById(R.id.totalPriceText);
        }

        public void update(SaleProduct product) {
            productIdText.setText("Product ID: " + product.getId());
            quantityText.setText("Quantity: " + product.getQuantity());
            totalPriceText.setText("Total: " + product.getTotalPrice() + "€");
        }
    }
}
