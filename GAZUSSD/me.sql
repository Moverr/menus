select distinct(a.MSISDN) as PhoneNumbers, date(a.dateCreated) from c_activities a where a.accessPoint='*206#' and a.MSISDN  not i
                                      n (select distinct(r.MSISDN) from s_requestLogs r inner join s_payments p on r.requestLogID=p.requestLogID inner join c_channelReq
                                      uests c on c.channelRequestID=r.hubID where c.accessPoint='*206#' and r.overallStatus in (140,141) and date(r.dateCreated) >= '201
                                      9-03-01 00:00:00' and date(r.dateCreated) <= '2019-05-31 23:59:59')and date(a.dateCreated) >= '2019-03-01 00:00:00' and date(a.dat
                                      eCreated) <= '2019-05-31 23:59:59' group by a.MSISDN;