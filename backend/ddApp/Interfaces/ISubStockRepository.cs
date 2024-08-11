using ddApp.Models;

namespace ddApp.Interfaces
{
    public interface ISubStockRepository
    {
        ICollection<SubStock> GetSubStocks();
        SubStock GetSubStock(int id);
        bool SubStockExists(int id);
        bool CreateSubStock(SubStock subStock);
        bool UpdateSubStock(SubStock subStock);
        bool DeleteSubStock(SubStock subStock);
        bool Save();
        ICollection<SubStock> GetSubStocksByUserId(int userId);
    }

}
