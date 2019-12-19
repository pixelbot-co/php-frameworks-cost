
function done(summary, latency, requests)

   local row = "---{\"ts\":%s, \"lat\":{\"min\":%s, \"max\":%s, \"mean\":%s, \"stdev\":%s, \"p50\":%s, \"p75\":%s, \"p90\":%s, \"p99\":%s}, \"dur\":%s, \"req\":%s, \"byt\": %s, \"err\":{\"connect\":%s, \"read\": %s, \"write\":%s, \"status\":%s, \"timeout\":%s}}---"
   print(row:format(
      os.time(os.date("!*t")),
      latency.min,
      latency.max,
      latency.mean,
      latency.stdev,
      latency:percentile(50.0),
      latency:percentile(75.0),
      latency:percentile(90.0),
      latency:percentile(99.0),
      summary.duration,
      summary.requests,
      summary.bytes,
      summary.errors.connect,
      summary.errors.read,
      summary.errors.write,
      summary.errors.status,
      summary.errors.timeout
   ))

end
