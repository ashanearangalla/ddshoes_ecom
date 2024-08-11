using ddApp.DAL;
using ddApp.Interfaces;
using ddApp.Models;
using System.Linq;

namespace ddApp.Repository
{
    public class MainStockRepository : IMainStockRepository
    {
        private readonly DataContext _context;

        public MainStockRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<MainStock> GetMainStocks()
        {
            return _context.MainStocks.ToList();
        }

        public MainStock GetMainStock(int id)
        {
            return _context.MainStocks.Find(id);
        }

        public bool MainStockExists(int id)
        {
            return _context.MainStocks.Any(ms => ms.MainStockID == id);
        }

        public bool CreateMainStock(MainStock mainStock)
        {
            _context.MainStocks.Add(mainStock);
            return Save();
        }

        public bool UpdateMainStock(MainStock mainStock)
        {
            _context.MainStocks.Update(mainStock);
            return Save();
        }

        public bool DeleteMainStock(MainStock mainStock)
        {
            _context.MainStocks.Remove(mainStock);
            return Save();
        }

        public bool Save()
        {
            return _context.SaveChanges() > 0;
        }

        public bool UpdateStock(int productId, int soldQuantity)
        {
            var mainStock = _context.MainStocks.FirstOrDefault(ms => ms.ProductID == productId);
            if (mainStock == null)
                return false;

            mainStock.Sold += soldQuantity;
            return Save();
        }
    }
}
