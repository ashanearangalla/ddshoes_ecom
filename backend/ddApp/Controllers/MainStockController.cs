using AutoMapper;
using ddApp.Dto;
using ddApp.Interfaces;
using ddApp.Models;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Linq;

namespace ddApp.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class MainStockController : ControllerBase
    {
        private readonly IMainStockRepository _mainStockRepository;
        private readonly IMapper _mapper;

        public MainStockController(IMainStockRepository mainStockRepository, IMapper mapper)
        {
            _mainStockRepository = mainStockRepository;
            _mapper = mapper;
        }

        [HttpGet]
        [ProducesResponseType(200, Type = typeof(IEnumerable<MainStockDto>))]
        public IActionResult GetMainStocks()
        {
            var mainStocks = _mapper.Map<List<MainStockDto>>(_mainStockRepository.GetMainStocks());

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(mainStocks);
        }

        [HttpGet("{mainStockId}")]
        [ProducesResponseType(200, Type = typeof(MainStockDto))]
        [ProducesResponseType(400)]
        public IActionResult GetMainStock(int mainStockId)
        {
            if (!_mainStockRepository.MainStockExists(mainStockId))
                return NotFound();

            var mainStock = _mapper.Map<MainStockDto>(_mainStockRepository.GetMainStock(mainStockId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(mainStock);
        }

        [HttpPost]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult CreateMainStock([FromBody] MainStockDto mainStockCreate)
        {
            if (mainStockCreate == null)
                return BadRequest(ModelState);

            var mainStock = _mainStockRepository.GetMainStocks()
                .FirstOrDefault(m => m.MainStockID == mainStockCreate.MainStockID);

            if (mainStock != null)
            {
                ModelState.AddModelError("", "MainStock already exists");
                return StatusCode(422, ModelState);
            }

            var mainStockMap = _mapper.Map<MainStock>(mainStockCreate);

            if (!_mainStockRepository.CreateMainStock(mainStockMap))
            {
                ModelState.AddModelError("", "Something went wrong while saving");
                return StatusCode(500, ModelState);
            }

            return Ok("Successfully created");
        }

        [HttpPut("{mainStockId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult UpdateMainStock(int mainStockId, [FromBody] MainStockDto updatedMainStock)
        {
            if (updatedMainStock == null || mainStockId != updatedMainStock.MainStockID)
                return BadRequest(ModelState);

            if (!_mainStockRepository.MainStockExists(mainStockId))
                return NotFound();

            var mainStockMap = _mapper.Map<MainStock>(updatedMainStock);

            if (!_mainStockRepository.UpdateMainStock(mainStockMap))
            {
                ModelState.AddModelError("", "Something went wrong while updating");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpDelete("{mainStockId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult DeleteMainStock(int mainStockId)
        {
            if (!_mainStockRepository.MainStockExists(mainStockId))
                return NotFound();

            var mainStock = _mainStockRepository.GetMainStock(mainStockId);

            if (!_mainStockRepository.DeleteMainStock(mainStock))
            {
                ModelState.AddModelError("", "Something went wrong while deleting");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpPut("updateStock/{productId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult UpdateStock(int productId, [FromBody] int soldQuantity)
        {
            if (!_mainStockRepository.UpdateStock(productId, soldQuantity))
            {
                ModelState.AddModelError("", "Something went wrong while updating stock");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }
    }
}
