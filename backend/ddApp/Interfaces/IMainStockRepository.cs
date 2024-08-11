using ddApp.Models;

namespace ddApp.Interfaces
{
    public interface IMainStockRepository
    {
        ICollection<MainStock> GetMainStocks();
        MainStock GetMainStock(int id);
        bool MainStockExists(int id);
        bool CreateMainStock(MainStock mainStock);
        bool UpdateMainStock(MainStock mainStock);
        bool DeleteMainStock(MainStock mainStock);
        bool Save();
        bool UpdateStock(int productId, int soldQuantity);
    }
}