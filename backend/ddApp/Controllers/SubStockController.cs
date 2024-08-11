using AutoMapper;
using ddApp.Dto;
using ddApp.Interfaces;
using ddApp.Models;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;

namespace ddApp.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class SubStockController : ControllerBase
    {
        private readonly ISubStockRepository _subStockRepository;
        private readonly IMapper _mapper;

        public SubStockController(ISubStockRepository subStockRepository, IMapper mapper)
        {
            _subStockRepository = subStockRepository;
            _mapper = mapper;
        }

        [HttpGet]
        [ProducesResponseType(200, Type = typeof(IEnumerable<SubStockDto>))]
        public IActionResult GetSubStocks()
        {
            var subStocks = _mapper.Map<List<SubStockDto>>(_subStockRepository.GetSubStocks());

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(subStocks);
        }

        [HttpGet("{subStockId}")]
        [ProducesResponseType(200, Type = typeof(SubStockDto))]
        [ProducesResponseType(400)]
        public IActionResult GetSubStock(int subStockId)
        {
            if (!_subStockRepository.SubStockExists(subStockId))
                return NotFound();

            var subStock = _mapper.Map<SubStockDto>(_subStockRepository.GetSubStock(subStockId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(subStock);
        }

        [HttpPost]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult CreateSubStock([FromBody] SubStockDto subStockCreate)
        {
            if (subStockCreate == null)
                return BadRequest(ModelState);

            var subStock = _subStockRepository.GetSubStocks()
                .Where(s => s.SubStockID == subStockCreate.SubStockID)
                .FirstOrDefault();

            if (subStock != null)
            {
                ModelState.AddModelError("", "SubStock already exists");
                return StatusCode(422, ModelState);
            }

            var subStockMap = _mapper.Map<SubStock>(subStockCreate);

            if (!_subStockRepository.CreateSubStock(subStockMap))
            {
                ModelState.AddModelError("", "Something went wrong while saving");
                return StatusCode(500, ModelState);
            }

            return Ok("Successfully created");
        }

        [HttpPut("{subStockId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult UpdateSubStock(int subStockId, [FromBody] SubStockDto updatedSubStock)
        {
            if (updatedSubStock == null || subStockId != updatedSubStock.SubStockID)
                return BadRequest(ModelState);

            if (!_subStockRepository.SubStockExists(subStockId))
                return NotFound();

            var subStockMap = _mapper.Map<SubStock>(updatedSubStock);

            if (!_subStockRepository.UpdateSubStock(subStockMap))
            {
                ModelState.AddModelError("", "Something went wrong while updating");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpDelete("{subStockId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult DeleteSubStock(int subStockId)
        {
            if (!_subStockRepository.SubStockExists(subStockId))
                return NotFound();

            var subStock = _subStockRepository.GetSubStock(subStockId);

            if (!_subStockRepository.DeleteSubStock(subStock))
            {
                ModelState.AddModelError("", "Something went wrong while deleting");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        // New endpoint to get sub-stocks by user ID
        [HttpGet("user/{userId}")]
        [ProducesResponseType(200, Type = typeof(IEnumerable<SubStockDto>))]
        [ProducesResponseType(400)]
        public IActionResult GetSubStocksByUserId(int userId)
        {
            var subStocks = _mapper.Map<List<SubStockDto>>(_subStockRepository.GetSubStocksByUserId(userId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(subStocks);
        }
    }
}
