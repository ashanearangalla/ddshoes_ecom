using ddApp.Models;

namespace ddApp.Interfaces
{
    public interface ISaleRepository
    {
        ICollection<Sale> GetSales();
        Sale GetSale(int id);
        bool SaleExists(int id);
        bool CreateSale(Sale sale);
        bool UpdateSale(Sale sale);
        bool DeleteSale(Sale sale);
        bool Save();
    }
}
